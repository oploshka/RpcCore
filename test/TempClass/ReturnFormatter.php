<?php

namespace Oploshka\RpcTest\TempClass;

class ReturnFormatter implements \Oploshka\RpcInterface\ReturnFormatter{
  public function format($methodName, $methodData, $Response, $ErrorStore) {
    return [
      $methodName, $methodData, $Response, $ErrorStore
    ];
  }
}