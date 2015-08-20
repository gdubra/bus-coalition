<?php

namespace BusCoalition\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends BaseController
{
    public function form_bootstrapAction()
    {
        $formulaFundSources = $this->getRepo('FundSource')->getFormulaFundSources();
        $discretionaryFundSources = $this->getRepo('FundSource')->getDiscretionaryFundSources();
        $types = $this->getRepo('VehicleType')->findAll();
        $fundingInflationRate = $this->container->getParameter('funding_inflation_rate');
        $fleetInflationRate = $this->container->getParameter('fleet_inflation_rate');
        $companyTemplate = array('fundSources'=>array('formula'=>$formulaFundSources,'discretionary'=>$discretionaryFundSources),'fleet'=>$types,'fundingInflationRate'=>$fundingInflationRate,'fleetInflationRate'=>$fleetInflationRate);
        return $this->ajaxSuccessResponse(array('company_template'=>$companyTemplate));
    }
}
