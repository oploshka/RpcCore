<?php

namespace Oploshka\RpcAbstract;


abstract class Method implements \Oploshka\RpcInterface\Method {
  
  /**
   * @var \Oploshka\Rpc\RpcResponse
   */
  protected $Response;
  protected $Data;
  protected $Logger;

  public function __construct($obj){
    $this->Response = $obj['response'];
    $this->Data     = $obj['data'];
    $this->Logger   = $obj['logger'];
  }
  
  public static function description() { return ''; }
  
  // public static function requestSchema() { return []; }
  // public static function responseSchema() { return []; }
  
  abstract public function run();
  
  // сокращения
  protected function setData($key, $value){
    $this->Response->setData($key, $value);
    return $this;
  }
  
  // сокращения по ошибкам
  /*
  protected function error($error): RpcResponse {
    $this->Response->error($error);
    return $this;
  }
  */
  protected function setErrorCode($code){
    $this->Response->setErrorCode($code);
    return $this;
  }
  protected function setErrorMessage($message){
    $this->Response->setErrorMessage($message);
    return $this;
  }
  protected function setErrorData($data){
    $this->Response->setErrorData($data);
    return $this;
  }
  

}
