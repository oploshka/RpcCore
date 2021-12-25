<?php

namespace Oploshka\RpcExample\Method\Error;

use Oploshka\RpcExample\Enum\MethodError;

class RunUnknownFunction extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected EmptyRequest $Data;
  
  public function run() {
    // попытка запустить что то не существующее
    unknownFunction(123);
    
    $this->setErrorCode(MethodError::ERROR_NO);
  }
}