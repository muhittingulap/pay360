<?php

namespace PAY360\Config;

class config {

    private $username="MAIL_API_USERNAME";
    private $password="MAIL_API_PASSWORD";

    private $cardLockId="MAIL_CARDLOCK_ID";
    private $hostedCashierId="MAIL_INSTALLATIONS_HOSTED_CASHIER";
    private $cashierId="MAIL_INSTALLATIONS_CASHIER_ID";
    
    private $prod_url="https://api.pay360.com/acceptor/rest/";
    private $test_url="https://api.mite.pay360.com/acceptor/rest/";

    protected $type=0; // test or prod
    protected $integrationMethod=0; // 0: Hosted Cashier 1: Cashier API
    protected $method=''; // POST or GET
    protected $post_data=array(); // POST array data

    public function getUrl(){
        return $this->{($type==0?'test':'prod')}.'_url';
    }

    public function getHeaders(){        

        $basic_auth=base64_encode($this->username.':'.$this->password);

        return array(
            'Authorization: Basic ' . $basic_auth . '',
            'Content-Type: application/json',
        );
    }

    public function call(){

        $array=array(
            CURLOPT_URL => $this->getUrl(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => 'UTF-8',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_HTTPHEADER => $this->getHeaders();
        );         

        if($this->method=="POST") $array["CURLOPT_POSTFIELDS"] = json_encode($this->post_data);

        $curl = curl_init();

        curl_setopt_array($curl, $array));    

        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
          $return=array(
              "status" => 0,
              "data" => array(
                  "error_no" => curl_errno($curl),
                  "message" => curl_error($curl),
              ),
          );
        }else{
            $return=array(
                "status" => 0,
                "data" => json_decode($response, true),
            );
        }

        curl_close($curl);

        return $return;
    }

}