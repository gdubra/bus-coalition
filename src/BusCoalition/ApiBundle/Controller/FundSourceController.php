<?php
namespace BusCoalition\ApiBundle\Controller;

use BusCoalition\ApiBundle\Controller\BaseController;

class FundSourceController extends BaseController{
    
    public function bootstrapAction(){
        $formulaFundSources = $this->getRepo('FundSource')->getFormulaFundSources();
        $discretionaryFundSources = $this->getRepo('FundSource')->getDiscretionaryFundSources();
        return $this->ajaxSuccessResponse(array('fund_sources'=>array('formula'=>$formulaFundSources,'discretionary'=>$discretionaryFundSources)));
    }
}