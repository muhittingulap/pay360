<?php

namespace PAY360\Libraries;

use PAY360\Config\config;

class transactions extends config{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function verify()){
        try{
            $return= $this->setUrlEk(__FUNCTION__)
                          ->setMethod("POST")
                          ->call();
        } catch (Exception $e) {
          
        } 

        return $return;
    }
    
}