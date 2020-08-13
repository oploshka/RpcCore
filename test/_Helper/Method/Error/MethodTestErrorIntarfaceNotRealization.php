<?php

namespace Oploshka\RpcHelperTest\Method\Error;

class MethodTestErrorIntarfaceNotRealization extends \Oploshka\RpcAbstract\Method {

  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }

  public static function requestSchema(){
    return [];
  }

  public function run(){
    $this->Response->error('ERROR_NO');
  }

  // Not realization method responseSchema
  // public static function responseSchema(){
  //   return [];
  // }
}
