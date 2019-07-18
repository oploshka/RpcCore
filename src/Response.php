<?php

namespace Oploshka\Rpc;

class Response implements \Oploshka\RpcInterface\Response {
  
  private $error    = 'ERROR_DEFAULT' ;
  private $data     = [];

  public function getData(){
    return $this->data;
  }
  public function setData($key, $value){
    $this->data[$key] = $value;
  }

  public function getError(){
    return $this->error;
  }
  public function setError($name){
    $this->error = $name;
  }
  public function error($name){
    $this->setError($name);
    throw new \Exception('');
  }
}