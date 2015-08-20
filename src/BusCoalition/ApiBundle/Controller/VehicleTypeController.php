<?php
namespace BusCoalition\ApiBundle\Controller;

use BusCoalition\ApiBundle\Controller\BaseController;

class VehicleTypeController extends BaseController{
    
    public function bootstrapAction(){
        $types = $this->getRepo('VehicleType')->findAll();
        return $this->ajaxSuccessResponse(array('fleet'=>$types));
    }
}