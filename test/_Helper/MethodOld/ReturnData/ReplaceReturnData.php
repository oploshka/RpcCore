<?php

namespace Oploshka\RpcTestHelper\Method\ReturnData;

class ReplaceReturnData extends \Oploshka\RpcAbstract\Method {
  
  public static function description(){ return ''; }
  public static function requestSchema(){ return [];  }
  public static function responseSchema(){ return []; }
  
  public function run(){
    $this->Response->setData('test1::string', 'test string');
    $this->Response->setData('test1::int', 1);

    $this->Response->setErrorCode('ERROR_NO');
  }
}
