<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcExample\Enum\MethodError;

class TestDiLogger extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected TestDiLoggerRequest $Data;
  
  public function run() {
    // TODO: add logger support
    // $this->Logger->info('testLog', ['testLogKey' => 'testLogValue']);
    $this->setErrorCode(MethodError::ERROR_NO);
  }

}
