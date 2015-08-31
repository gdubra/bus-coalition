<?php
namespace BusCoalition\ApiBundle\Repository;

use BusCoalition\ApiBundle\Entity\FundSource;
use Doctrine\ORM\EntityRepository;

class FundSourceRepository extends EntityRepository{
    
    public function getMaxMinFundSourceYear(){
        $query = $this->createQueryBuilder('f')
        ->select('MIN(f.startYear) AS min_year , MAX(f.endYear) AS max_year')
        ->getQuery();
        $query->useResultCache(true,0,'max_year');
        $result = $query->getScalarResult();
        $result = $result[0]; 
        $actual_year = date('Y');
        if($result['max_year'] < $actual_year){
            if($this->checkEmptyEndYear()){
                $result->max_year = $actual_year; 
            }
        }
        
        return array($result['min_year'],$result['max_year']);
    }
    
    
    public function getFormulaFundSources(){
        return $this->getFundSources(FundSource::FORMULA_FUND_SOURCE);
    }
    
    public function getDiscretionaryFundSources(){
        return $this->getFundSources(FundSource::DISCRETIONARY_FUND_SOURCE);
    }
    
    private function getFundSources($type){
        $query = $this->createQueryBuilder('f')
        ->where('f.type = :type')
        ->setParameter('type',$type)
        ->getQuery();
        $query->useResultCache(true,0,'formula_fund_sources');
        return $query->getResult();
    }
    
    private function checkEmptyEndYear(){
        $query = $this->createQueryBuilder('f')
        ->select('count(*) as empty_end_years')
        ->where('end_year is null')
        ->getQuery();
        $query->useResultCache(true,0,'check_empty_end_years');
        $result = $query->getSingleScalarResult();
        return $result->empty_end_years > 0;
    }
}