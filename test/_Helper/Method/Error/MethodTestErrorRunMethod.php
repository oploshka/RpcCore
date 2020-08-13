<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodTestErrorRunMethod extends \Oploshka\RpcAbstract\Method {

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
    $this->Response->error('ERROR_NO');
  }

  public static function responseSchema(){
    return [];
  }
}
