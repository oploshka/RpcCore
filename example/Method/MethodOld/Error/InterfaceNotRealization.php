<?php

namespace Oploshka\RpcTestHelper\Method\Error;

class InterfaceNotRealization extends \Oploshka\RpcAbstract\rpcMethod {

  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }

  public static function requestSchema(){
    return [];
  }

  public function run(){
    $this->Response->setErrorCode('ERROR_NO');
  }

  // Not realization method responseSchema
  // public static function responseSchema(){
  //   return [];
  // }
}
