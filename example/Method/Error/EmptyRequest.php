<?php

namespace Oploshka\RpcExample\Method\Error;

use Oploshka\RpcContract\iRpcMethodRequest;

class EmptyRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [];
  }
  
  public function __construct(array $data) {}
  
}
