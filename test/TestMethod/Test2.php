<?php

namespace Oploshka\RpcTest\TestMethod;

class Test2 implements \Oploshka\Rpc\iMethod {
  
  public function description(){
    return <<<DESCRIPTION
Test description
DESCRIPTION;
  }
  
  public function validate(){
    return [];
  }
  
  public function run(&$_RESPONSE, $_DATA = array() ){
    $_RESPONSE->infoAdd('string', 'test string');
    $_RESPONSE->infoAdd('int', 1);
    $_RESPONSE->error('ERROR_NOT');
  }
  
  
  public function return(){
    return [];
  }
  
}