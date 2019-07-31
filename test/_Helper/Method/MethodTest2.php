<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodTest2 extends \Oploshka\Rpc\Method {
  
  public static function description(){
    return <<<DESCRIPTION
Test description
DESCRIPTION;
  }
  
  public static function validate(){
    return [];
  }
  
  public function run(){
    $this->Response->setData('methodName', 'MethodTest2');
    $this->Response->setError('ERROR_NO');
  }

  public static function return(){
    return [];
  }
  
}