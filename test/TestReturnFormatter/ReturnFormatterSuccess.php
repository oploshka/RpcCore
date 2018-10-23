<?php

namespace Oploshka\RpcTest\TestReturnFormatter;

class ReturnFormatterSuccess implements \Oploshka\Rpc\iReturnFormatter{
  public function prepare($loadData, &$methodName, &$methodData) {
    return 'ERROR_NOT';
  }
  public function format($methodName, $methodData, $Response, $ErrorStore) {
    return '';
  }
}