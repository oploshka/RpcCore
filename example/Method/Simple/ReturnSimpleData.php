<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcExample\Enum\MethodError;

class ReturnSimpleData extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected ?ReturnSimpleDataRequest $Data = null;
  
  public function run() {
    $this->setData('test1::string', 'test string');
    $this->setData('test1::int', 1);
    $this->setData('test1', 'testLog');
    $this->setData('methodName', 'MethodTest2');
    $this->setData('test1::string', 'test string');
    $this->setData('test1::int', 1);
    
    $this->setErrorCode(MethodError::ERROR_NO);
  }
  
}
