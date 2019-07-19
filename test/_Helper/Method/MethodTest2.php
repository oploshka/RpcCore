<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodTest2 extends \Oploshka\Rpc\Method {
  
  public function description(){
    return <<<DESCRIPTION
Test description
DESCRIPTION;
  }
  
  public function validate(){
    return [];
  }
  
  public function run(){
    $this->Response->setData('methodName', 'MethodTest2');
    $this->Response->setError('ERROR_NOT');
  }

  public function return(){
    return [];
  }
  
}