<?php

namespace Oploshka\RpcTest\TempClass;

class MethodTest1 extends \Oploshka\Rpc\Method {
  
  public function description(){
    return <<<DESCRIPTION
Test description
DESCRIPTION;
  }
  
  public function validate(){
    return [];
  }
  
  public function run(){

    $this->Response->setData('test1::string', 'test string');
    $this->Response->setData('test1::int', 1);

    $this->Response->error('ERROR_NOT');
  }
  
  public function return(){
    return [];
  }
  
}