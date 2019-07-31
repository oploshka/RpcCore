<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodTest1 extends \Oploshka\Rpc\Method {
  
  public static function description(){
    return <<<DESCRIPTION
Test description
DESCRIPTION;
  }
  
  public static function validate(){
    return [];
  }
  
  public function run(){

    $this->Response->setData('test1::string', 'test string');
    $this->Response->setData('test1::int', 1);

    $this->Response->error('ERROR_NO');
  }
  
  public static function return(){
    return [];
  }
  
}