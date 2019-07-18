<?php

namespace Oploshka\RpcTest\TestMethod;

class MethodTest2 extends \Oploshka\Rpc\Method {
  
  public function description(){
    return <<<DESCRIPTION
Test description
DESCRIPTION;
  }
  
  public function validate(){
    return [];
  }
  
  public function run(&$_RESPONSE, $_DATA = array() ){
    $this->Response->infoAdd('string', 'test string');
    $this->Response->infoAdd('int', 1);
    $this->Response->error('ERROR_NOT');
  }
  
  
  public function return(){
    return [];
  }
  
}