<?php

namespace Oploshka\RpcTestHelper\Method\Error;

class RunUnknownFunction extends \Oploshka\RpcAbstract\Method {

  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }

  public static function requestSchema(){
    return [];
  }

  public function run(){
    // попытка запустить что то не существующее
    ololo(123);
    $this->Response->setErrorCode('ERROR_NO');
  }

  public static function responseSchema(){
    return [];
  }
}
