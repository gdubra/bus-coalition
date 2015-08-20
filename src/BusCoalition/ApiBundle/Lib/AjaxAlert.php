<?php 
namespace BusCoalition\ApiBundle\Lib;

class AjaxAlert{
    
    //warning,danger,success 
    public $type;
    public $msg;
    
    public function __construct($type, $msg){
        $this->type = $type;
        $this->msg= $msg;
    }
    
    public static function successAlert($msg){
        return new AjaxAlert('success',$msg);
    }
    
    public static function warningAlert($msg){
        return new AjaxAlert('warning',$msg);
    }
    
    public static function dangerAlert($msg){
        return new AjaxAlert('danger',$msg);
    }
}
