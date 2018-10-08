<?php

namespace Oploshka\RpcCoreTest\TestMethod;

class Test1 implements \Oploshka\RpcCore\RpcMethod {
  
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
  
}