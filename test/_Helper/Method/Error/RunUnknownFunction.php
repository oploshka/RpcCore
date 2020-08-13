<?php

namespace Oploshka\RpcTestHelper\Method\Error;

class RunUnknownFunction extends \Oploshka\RpcAbstract\Method {
  
  public static function description(){ return ''; }
  public static function requestSchema(){ return [];  }
  public static function responseSchema(){ return []; }
  
  public function run(){
    // попытка запустить что то не существующее
    $t = 1;
    ololo(123);
    $this->Response->setErrorCode('ERROR_NO');
  }
}
