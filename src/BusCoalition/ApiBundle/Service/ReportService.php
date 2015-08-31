<?php
namespace BusCoalition\ApiBundle\Service;

use Doctrine\ORM\EntityManager;

class ReportService {
    
    private $phpExcel;
    private $em;
    private $fundSourceRepo;
    
    public function __construct($phpExcel,EntityManager $em){
        $this->phpExcel = $phpExcel;
        $this->em = $em;
        $this->fundSourceRepo = $em->getRepository('BusCoalitionApiBundle:FundSource');
    }
    
    public function generateInputReport($data,$filename){
        $phpExcelObject = $this->phpExcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setCreator("bus-coalition")
        ->setLastModifiedBy("Bus Coalition")
        ->setTitle("Bus Coalition {$data->basic_info->name} Inputs" )
        ->setSubject("Office Report");
        $this->inputFundingDataSheet($phpExcelObject, $data);
        $this->inputFleetDataSheet($phpExcelObject, $data);
        
        $phpExcelObject->setActiveSheetIndex(0);
        $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel5');
        $writer->save($filename);
    }
    
    private function inputFundingDataSheet($phpExcelObject,$data){
        list($first,$last) = $this->fundSourceRepo->getMaxMinFundSourceYear();
        $range = range($first,$last);
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', "Funding Data");
        $phpExcelObject->getActiveSheet()->setCellValue('A2', "Source\Years");
        $phpExcelObject->getActiveSheet()->setTitle('Funding Data');
        $row = $phpExcelObject->getActiveSheet()->getRowIterator(2)->current();
        $cellIterator = $row->getCellIterator('A');
        $cellIterator->setIterateOnlyExistingCells(false);
        $cellIterator->next();
        //SET YEARS TITLES
        foreach ($range as $year) {
            $cell = $cellIterator->current();
            $cell->setValue($year);
            $cellIterator->next();
        }
        
        
        foreach ($data->fundSources as $index=>$fundSource){
            $rowIndex=$index+3;
            $phpExcelObject->getActiveSheet()->setCellValue("A{$rowIndex}", $fundSource->name);
            $row = $phpExcelObject->getActiveSheet()->getRowIterator($rowIndex)->current();
            if(isset($fundSource->donations)){
                $fundSourceObject = $this->fundSourceRepo->findOneByName($fundSource->name);
                $endYear = $fundSourceObject->getEndYear()?  $fundSourceObject->getEndYear():$last;
                $range = range($fundSourceObject->getStartYear(),$endYear);
                $column = $this->getYearColumn($fundSourceObject->getStartYear(),$phpExcelObject);
                $cellIterator = $row->getCellIterator($column);
        
                 
                foreach ($range as $year){
                    $donation = isset($fundSource->donations->{$year})? $fundSource->donations->{$year} : 0;
                    $cell = $cellIterator->current();
                    $cell->setValue($donation);
                    $cell->getStyle()->getFill()->applyFromArray(array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                    'rgb' => 'ffcbf8'
                            )
                    ));
        
                    $cell = $cellIterator->next();
                }
            }
        }
    }
    
    private function getYearColumn($year,$phpExcelObject){
        $row = $phpExcelObject->getActiveSheet()->getRowIterator(2)->current();
        $cellIterator = $row->getCellIterator('A');
        foreach ($cellIterator as $cell){
            if($cell->getValue() == $year){
                return $cell->getColumn();
            }
        }
    }
    
    private function inputFleetDataSheet($phpExcelObject,$data){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $phpExcelObject->createSheet(1);
        $phpExcelObject->setActiveSheetIndex(1)->setCellValue('A1', "Fleet Data");
        
        $phpExcelObject->getActiveSheet()->setTitle('Fleet Data');
        $phpExcelObject->getActiveSheet()->setCellValue('D2', "Amt Reaching Useful Life");
        $phpExcelObject->getActiveSheet()->mergeCells('D2:J2');
        $phpExcelObject->getActiveSheet()->setCellValue('A3', "Bus Type");
        $phpExcelObject->getActiveSheet()->setCellValue('B3', "are Changeable");
        $phpExcelObject->getActiveSheet()->setCellValue('C3', "Amt in Fleet");
        
        $row = $phpExcelObject->getActiveSheet()->getRowIterator(3)->current();
        $cellIterator = $row->getCellIterator('D');
        $cellIterator->setIterateOnlyExistingCells(false);
        foreach ($range as $year){
            $cell = $cellIterator->current();
            $cell->setValue($year);
            $cellIterator->next();
        }
        
        foreach($data->fleet as $index=>$vehicle){
            $rowIndex=$index+4;
            $phpExcelObject->getActiveSheet()->setCellValue("A{$rowIndex}", $vehicle->name);
            $phpExcelObject->getActiveSheet()->setCellValue("B{$rowIndex}", $vehicle->price);
            $phpExcelObject->getActiveSheet()->setCellValue("C{$rowIndex}", isset($vehicle->amount)?$vehicle->amount:0);
            $row = $phpExcelObject->getActiveSheet()->getRowIterator($rowIndex)->current();
            $cellIterator = $row->getCellIterator('D');
            foreach ($range as $year){
                $cell = $cellIterator->current();
                $replacement = isset($vehicle->replacements->{$year})? $vehicle->replacements->{$year} : 0;
                $cell->setValue($replacement);
                $cell->getStyle()->getFill()->applyFromArray(array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                                'rgb' => 'ffcbf8'
                        )
                ));
                $cellIterator->next();
            }
        }
     
        
    }
    
    public function getChartsData($data){
       $chart1Data = $this->getChart1Data($data);
       $chart2Data = $this->getChart2Data($data);
       $chart3Data = $this->getChart3Data($data);
       return array('chart1'=>$chart1Data,'chart2'=>$chart2Data,'chart3'=>$chart3Data);
    }

    public function getChart1Data($data){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $expectedExpenses = $this->calculateExpectedExpenses($data);
        $fundSource = $this->getFundSourceOnData($data, 'fund2');
        $expectedDonations = $this->calculateExpectedDonationsForSource($data, $fundSource);
        $chart1Series = array();
        $chart1Series[] = array('name'=>"{$fundSource->name} Facilities",'data'=>array_values($expectedDonations));
        $chart1Series[] = array('name'=>"Expected Bus Expenditures",'data'=>array_values($expectedExpenses));
        return array('categories'=>$range, 'series'=>$chart1Series);
    }
    
    public function getChart3Data($data){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);

        $chartData = array();
        $labels = array();
        $chartSeries = array();
        foreach ($data->fundSources as $fundSource){
            $chartSeriesItem = array();
            $chartSeriesItem['name'] = $fundSource->name;
            $expectedDonations = $this->calculateExpectedDonationsForSource($data, $fundSource);
            $chartSeriesItem['data']= array_values($expectedDonations);
            $chartSeries[] = $chartSeriesItem;
        }
        
        
        return array('categories'=>$range, 'series'=>$chartSeries);
    }
    
    public function getChart2Data($data){
        $fundSource = $this->getFundSourceOnData($data, 'fund1');
        $fundSource2 = $this->getFundSourceOnData($data, 'fund2');
        $fundSource2ExpectedDonations = $this->calculateExpectedDonationsForSource($data, $fundSource2);
        $keys = array_keys(get_object_vars($fundSource->donations));
        $firstYear = $keys[0];
        $currentYear = date('Y');
        $range = range($firstYear,$currentYear+6);
        $chartSeries = array();
        $fund1Donations = array();
        $fund2Donations = array();
        foreach ($range as $year){
            $fund1Donation[] = isset($fundSource->donations->{$year})?$fundSource->donations->{$year}:0;
            if($year > $currentYear){
                $fund2Donation[] = $fundSource2ExpectedDonations[$year];
            }else{
                $fund2Donation[] = isset($fundSource2->donations->{$year})?$fundSource2->donations->{$year}:0;
            }
        }
        $chartSeries[] = array('name'=>$fundSource->name,'data'=>$fund1Donation);
        $chartSeries[] = array('name'=>$fundSource2->name,'data'=>$fund2Donation);
        return array('categories'=>$range, 'series'=>$chartSeries);
    }
    
    public function calculateExpectedExpenses($data){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $costPerYear = array_fill_keys ( $range , 0 );
        foreach($data->fleet as $vehicle){
            foreach ($range as $year){
                if(isset($vehicle->replacements->{$year})){
                    $costPerYear[$year] += $vehicle->replacements->{$year} * $vehicle->price * $this->getYearVehicleInlfationRate($year,$data->fleetInflationRate);
                }
            }
        }
        
        return $costPerYear;
    }
    
    public function calculateTotalExpenses($data){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $totalCost = 0;
        foreach($data->fleet as $vehicle){
            foreach ($range as $year){
                if(isset($vehicle->replacements->{$year})){
                    $totalCost += $vehicle->replacements->{$year} * $vehicle->price * $this->getYearVehicleInlfationRate($year,$data->fleetInflationRate);
                }
            }
        }
    
        return $totalCost;
    }
    
    public function calculateTotalVehicles($data){
        $currentYear = date('Y');
        
        $totalVehicles = 0;
        foreach($data->fleet as $vehicle){
            if(isset($vehicle->amount)){
                $totalVehicles += $vehicle->amount;
            }
        }
    
        return $totalVehicles;
    }
    
    public function calculateTotalReplacements($data){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $totalReplacements = 0;
        foreach($data->fleet as $vehicle){
            foreach ($range as $year){
                if(isset($vehicle->replacements->{$year})){
                    $totalReplacements += $vehicle->replacements->{$year};
                }
            }
        }
        
        return $totalReplacements;
    }
    
    
    
    private function getYearVehicleInlfationRate($year, $originalInflationRate){
        $currentYear = date('Y');
        $times = ($year - $currentYear) + 1;
        $yearInflationRate = $originalInflationRate*$times > 100 ? 100 : $originalInflationRate*$times;
        return (1 + $yearInflationRate/100);
    }
    
    public function calculateExpectedDonationsForSource($data,$fundSource){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $donationsPerYear = array_fill_keys ( $range , 0 );
         
        $baseDonation = 0;
        if(isset($fundSource->donations->{$currentYear}) && $fundSource->donations->{$currentYear} != 0 ){
            $baseDonation = $fundSource->donations->{$currentYear};
        }
        
        foreach($range as $year){
            $donationsPerYear[$year] =  $year == $currentYear? $baseDonation : $donationsPerYear[$year-1]  * (1+$data->fundingInflationRate) ;
        }
        
        return $donationsPerYear;
    }
    
    public function calculateTotalDonationsForSource($data,$fundSource){
        $currentYear = date('Y');
        $range = range($currentYear,$currentYear+6);
        $donationsPerYear = array_fill_keys ( $range , 0 );
        $totalDonations = 0;
         
        $baseDonation = 0;
        if(isset($fundSource->donations->{$currentYear}) && $fundSource->donations->{$currentYear} != 0 ){
            $baseDonation = $fundSource->donations->{$currentYear};
        }
    
        foreach($range as $year){
            $donationsPerYear[$year] =  $year == $currentYear? $baseDonation : $donationsPerYear[$year-1]  * (1+$data->fundingInflationRate) ;
            $totalDonations +=  $year == $currentYear? $baseDonation : $donationsPerYear[$year-1]  * (1+$data->fundingInflationRate) ;
        }
    
        return $totalDonations;
    }
    
    public function getFundSourceOnData($data,$fundSourceName){
        foreach( $data->fundSources as $source){
            if($source->name == $fundSourceName){
                return $source;
            }
        }
    } 
    
    public function getTotals($data){
        $totals = array();
        $fundSource2 = $this->getFundSourceOnData($data, 'fund2');
        $totals['cost'] = $this->calculateTotalExpenses($data);
        $totals['donations'] = $this->calculateTotalDonationsForSource($data,$fundSource2);
        $totals['vehicles'] = $this->calculateTotalVehicles($data);
        $totals['replacements'] = $this->calculateTotalReplacements($data);
        return $totals;
    }
}