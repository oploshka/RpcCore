<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcContract\iRpcMethodRequest;

class TestDiLoggerRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [];
  }
  
  public function __construct(array $data) {  }
  
}
