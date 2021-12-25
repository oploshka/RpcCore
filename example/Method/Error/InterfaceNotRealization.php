<?php

namespace Oploshka\RpcExample\Method\Error;

use Oploshka\RpcExample\Enum\MethodError;

class InterfaceNotRealization extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected EmptyRequest $Data;
  
  /*
  // !!! не реализуем обязательный метод !!!
  public function run() {
    $this->setErrorCode(MethodError::ERROR_NO);
  }
  */
}