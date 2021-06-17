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

    private $callMethod="transactions"; // customers or transactions
    private $method=""; // POST or GET
    private $url_ex=""; // örn: verify,resume or byRef

    protected $customerId=0; // pay360 customer Id
    protected $cardToken=""; // pay360 registered card token
    protected $transactionId=0; // transactionId 

    public function __construct()
    {

    }

    public function setCardToken($data=""){
        $this->cardToken=(string)$data;
        return $this;
    }

    public function setCustomerId($data=0){
        $this->customerId=(int)$data;
        return $this;
    }

    public function setUsername($data=""){
        $this->username=(string)$data;
        return $this;
    }

    public function setPassword($data=""){
        $this->password=(string)$data;
        return $this;
    }

    public function setCardLockId($data=""){
        $this->cardLockId=(string)$data;
        return $this;
    }

    public function setHostedCashierId($data=0){
        $this->hostedCashierId=(int)$data;
        return $this;
    }

    public function setCashierId($data=0){
        $this->cashierId=(int)$data;
        return $this;
    }

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

    protected function setCallMethod($data="")
    {
        $this->callMethod=(string)$data;
        return $this;
    }

    protected function setMethod($data="POST")
    {
        $this->method=(string)$data;
        return $this;
    }

    protected function setUrlEx($data="")
    {
        $this->url_ex=(string)$data;
        return $this;
    }

    public function setTransactionId($data=0)
    {
        $this->transactionId=(int)$data;
        return $this;
    }

    private function getUrl(){
        return $this->{($this->type==0?'test':'prod').'_url'}.$this->callMethod.'/'.($this->integrationMethod==0?$this->hostedCashierId.'/':$this->cashierId.'/').($this->transactionId!=0?$this->transactionId.'/':'').$this->url_ex;
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
            CURLOPT_HTTPHEADER => $this->getHeaders(),
        );         

        if($this->method=="POST") $array[CURLOPT_POSTFIELDS] = json_encode($this->post_data);

        $curl = curl_init();

        curl_setopt_array($curl, $array);    

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
                "status" => 1,
                "data" => json_decode($response, true),
            );
        }

        curl_close($curl);

        return $return;
    }

}