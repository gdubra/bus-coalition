<?php
namespace BusCoalition\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller{
    public function ajaxSuccessResponse($data=null,$message=false){
        return new Response(json_encode(array(
                'success' => true,
                'alerts' => $message !== false? array(array('type'=>'success','msg'=>$message)):null,
                'data' => $data
        ), JSON_NUMERIC_CHECK));
    }
    
    public function ajaxFailResponse($alerts,$errors=null){
        return new Response(json_encode(array(
                'success' => false,
                'alerts' => $alerts,
                'errors' => $errors
        ), JSON_NUMERIC_CHECK));
    }
    
    protected function getRepo($entity){
        return $this->getDoctrine()->getRepository("BusCoalitionApiBundle:{$entity}");
    }
}