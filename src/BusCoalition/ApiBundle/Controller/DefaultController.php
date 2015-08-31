<?php

namespace BusCoalition\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Ob\HighchartsBundle\Highcharts\Highchart;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends BaseController
{
    public function form_bootstrapAction()
    {
        $fundSources = $this->getRepo('FundSource')->findAll();
        $types = $this->getRepo('VehicleType')->findAll();
        $fundingInflationRate = $this->container->getParameter('funding_inflation_rate');
        $fleetInflationRate = $this->container->getParameter('fleet_inflation_rate');
        $companyTemplate = array('fundSources'=>$fundSources,'fleet'=>$types,'fundingInflationRate'=>$fundingInflationRate,'fleetInflationRate'=>$fleetInflationRate);
        return $this->ajaxSuccessResponse(array('company_template'=>$companyTemplate));
    }
    
    public function confirmAction(Request $request){
        $data = json_decode($request->getContent());
        $chartsData = $this->get('report_service')->getChartsData($data);
        $data->totals = $this->get('report_service')->getTotals($data);
        
        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption('javascript-delay', 10000);
        $snappy->setOption('dpi', 300);
        $snappy->setOption('page-size', 'Letter');
        $snappy->setOption('margin-bottom', '0');
        $snappy->setOption('margin-left', '0');
        $snappy->setOption('margin-right', '0');
        $snappy->setOption('margin-top', '0');
        
        $html = $this->renderView('BusCoalitionApiBundle:Default:report.html.twig', array(
                'year'=>date('Y'),
                'data'=>$data,
                'chart1' => $chartsData['chart1'],
                'chart2' => $chartsData['chart2'],
                'chart3' => $chartsData['chart3']
            ));
        
        $md5 =  md5($data->basic_info->name.time());
        $companyName = str_replace(' ', '_', trim($data->basic_info->name));
        $name = "{$companyName}_{$md5}"; 
        $snappy->generateFromHtml($html,"reports/{$name}.pdf");
        
        $this->get('report_service')->generateInputReport($data,"inputs/{$name}.xls");
        
        $links = array('report_link'=>$this->generateUrl('download_report',array('filename'=>$name),true),
                'input_link'=>$this->generateUrl('download_input',array('filename'=>$name),true)
        );
        
        $message = \Swift_Message::newInstance()
        ->setSubject('Bus Coalition Report')
        ->setFrom('info@buscoalition.com')
        ->setCc($this->container->getParameter('mail_cc'))
        ->setTo($data->basic_info->contact_email)
        ->setBody(
                $this->renderView(
                        'BusCoalitionApiBundle:Default:email.html.twig',$links
                ),
                'text/html'
        );
        if(!$this->get('mailer')->send($message)){
            return $this->ajaxFailResponse($links);
        }
        
        return $this->ajaxSuccessResponse($links);
    }
    
    public function download_inputAction($filename){
        $path = $this->get('kernel')->getRootDir(). "/../web/inputs/{$filename}.xls";
        $content = file_get_contents($path);
        
        $response = new Response();
        
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="buscoalition-input.xls"');
        
        $response->setContent($content);
        return $response;
    }
    
    public function download_reportAction($filename){
        $path = $this->get('kernel')->getRootDir(). "/../web/reports/{$filename}.pdf";
        $content = file_get_contents($path);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="buscoalition-report.pdf"');
        
        $response->setContent($content);
        return $response;
    }
}
