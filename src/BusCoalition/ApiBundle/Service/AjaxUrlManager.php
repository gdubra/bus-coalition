<?php
namespace BusCoalition\ApiBundle\Service;
use Symfony\Component\Templating\Helper\Helper;

class AjaxUrlManager extends Helper{
    
    private $router;
    private $csrf_provider;
    private $ajax_urls;
    
    public function __construct($router,$csrf_provider){
        $this->router = $router;
        $this->csrf_provider = $csrf_provider;
    }
    
    public function getName() {
        return 'AjaxUrlManager';
    }
    
    private function init_ajax_urls(){
        if(!isset($this->ajax_urls) || empty($this->ajax_urls)){
            $this->ajax_urls = array();
            $urls_array = $this->get_urls_array();
            foreach ($urls_array as $key=>$url){
                $this->ajax_urls[$key] = array(
                                        'url' => $url,
                                        'csrf' => $this->csrf_provider->generateCsrfToken($url),
                );
            }
        }
        
    }

    private function get_urls_array(){
        return array(
            'FORM_BOOTSTRAP'=>$this->router->generate('form_bootstrap'),
            'FUNDING_BOOTSTRAP'=>$this->router->generate('fund_source_bootstrap'),
            'FLEET_BOOTSTRAP'=>$this->router->generate('fleet_bootstrap'),
            'CONFIRM'=>$this->router->generate('confirm'),
        );
    }
    
    public function get_ajax_urls(){
        if(!isset($this->ajax_urls) || empty($this->ajax_urls)){
            $this->init_ajax_urls();
        }
        
        return  json_encode($this->ajax_urls);
    }
    
   
}