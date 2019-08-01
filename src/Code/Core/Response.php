<?php

namespace Oploshka\Rpc;

class Response implements \Oploshka\RpcInterface\Response {
  
  private $errorObj    = [
    'code'    => 'ERROR_DEFAULT',
    'message' => '',
    'data'    => [],
  ];
  private $data     = [];

  public function getData(){
    return $this->data;
  }
  public function setData($key, $value){
    $this->data[$key] = $value;
  }

  public function getError(){
    return $this->errorObj;
  }

  public function getErrorCode(){
    return $this->errorObj['code'];
  }

  public function setError($name, $message = '', $data = []){
    $this->errorObj['code']     = $name;
    $this->errorObj['message']  = $message;
    $this->errorObj['data']     = $data;
  }

  public function error($name, $message = '', $data = []){
    $this->setError($name, $message, $data);
    throw new MethodEndException('');
  }
}