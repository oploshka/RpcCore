<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodNotValid extends \Oploshka\Rpc\Method {

  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }

  public static function validate(){
    return [];
  }

  public function run(){
    ololo(123);
    $this->Response->error('ERROR_NO');
  }

  public static function return(){
    return [];
  }
}