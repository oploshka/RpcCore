<?php

namespace Oploshka\Rpc;

class Response implements ResponseInterface {
  
  private $error    = 'ERROR_DEFAULT' ;
  private $data     = [];
  private $log      = [];
  
  public function setData($key, $value){
    $this->data[$key] = $value;
  }
  public function setLog($key, $value = ''){
    if($value === ''){
      return;
    }
    $this->log[] = [$key => $value];
  }
  public function setError($name){
    $this->error = $name;
  }
  public function error($name){
    $this->setError($name);
    throw new \Exception('');
  }
  
  
  public function getData(){
    return $this->data;
  }
  public function getLog(){
    return $this->log;
  }
  public function getError(){
    return $this->error;
  }
  
}