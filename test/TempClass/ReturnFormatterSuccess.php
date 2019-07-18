<?php

namespace Oploshka\RpcTest\TempClass;

class ReturnFormatterSuccess implements \Oploshka\RpcInterface\ReturnFormatter{
  public function prepare($loadData, &$methodName, &$methodData) {
    return 'ERROR_NOT';
  }
  public function format($methodName, $methodData, $Response, $ErrorStore) {
    return '';
  }
}