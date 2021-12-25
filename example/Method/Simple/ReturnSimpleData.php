<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcExample\Enum\MethodError;

class ReturnSimpleData extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected ?ReturnSimpleDataRequest $Data = null;
  
  public function run() {
    $this->Response->setData('test1::string', 'test string');
    $this->Response->setData('test1::int', 1);
    $this->Response->setData('test1', 'testLog');
    $this->Response->setData('methodName', 'MethodTest2');
    $this->Response->setData('test1::string', 'test string');
    $this->Response->setData('test1::int', 1);
    
    $this->setErrorCode(MethodError::ERROR_NO);
  }
  
}
