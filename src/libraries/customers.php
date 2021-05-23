<?php

namespace PAY360\Libraries;

use PAY360\Config\config;

class customers extends config{
  
    public function __construct()
    {
        parent::__construct();
    }

    public function paymentMethodRemove(){
        try{  
                      
            $return= $this->setCallMethod("customers")
                          ->setUrlEx($this->customerId.'/paymentMethod/'.$this->cardToken.'/remove')
                          ->setMethod("POST")
                          ->call();

        } catch (Exception $e) {

            $return=array(
                "status" => 0,
                "data" => array(
                    "outcome"=> array(
                        "status" => "FAILED",
                        "reasonCode" => 'E0',
                        "reasonMessage" => $e->getMessage(),
                    ),
                ),
            );

        } 

        return $return;
    } 
    
}