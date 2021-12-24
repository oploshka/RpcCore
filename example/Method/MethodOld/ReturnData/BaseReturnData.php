<?php

namespace Oploshka\RpcTestHelper\Method\ReturnData;

class BaseReturnData extends \Oploshka\RpcAbstract\rpcMethod {
  
  public static function description(){ return ''; }
  public static function requestSchema(){ return [];  }
  public static function responseSchema(){ return []; }
  
  public function run(){
    $this->Response->setData('methodName', 'MethodTest2');

    $this->Response->setErrorCode('ERROR_NO');
  }
}
