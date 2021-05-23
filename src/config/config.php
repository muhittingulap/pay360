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

    private $type=0; // test or prod
    private $integrationMethod=0; // 0: Hosted Cashier 1: Cashier API
    private $cussomerPrefix="CUST-"; // customer prefix
    private $post_data=array(); // POST array data
    private $method=''; // POST or GET
    private $url_ek=""; // örn: verify,resume or byRef

    public function setType($data=0)
    {
        $this->type=(int)$data;
        return $this;
    }

    public function setIntegrationMethod($data=0)
    {
        $this->integrationMethod=(int)$data;
        return $this;
    }

    public function setCussomerPrefix($data="CUST-")
    {
        $this->cussomerPrefix=(string)$data;
        return $this;
    }

    public function setPostData($data=array())
    {
        $this->post_data=(array)$data;
        return $this;
    }

    protected function setMethod($data="POST")
    {
        $this->method=(string)$data;
        return $this;
    }

    protected function setUrlEk($data="")
    {
        $this->url_ek=(string)$data;
        return $this;
    }

    private function getUrl(){
        return $this->{($type==0?'test':'prod')}.'_url'.($this->integrationMethod==0?$this->hostedCashierId.'/':$this->cashierId.'/').$this->url_ek;
    }

    private function getHeaders(){        

        $basic_auth=base64_encode($this->username.':'.$this->password);

        return array(
            'Authorization: Basic ' . $basic_auth . '',
            'Content-Type: application/json',
        );
    }

    protected function call(){

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