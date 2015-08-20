<?php
namespace BusCoalition\ApiBundle\Repository;

use BusCoalition\ApiBundle\Entity\FundSource;
use Doctrine\ORM\EntityRepository;

class FundSourceRepository extends EntityRepository{
    
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
}