<?php

namespace Oploshka\RpcTest\TempClass;

class ReturnFormatterError implements \Oploshka\RpcInterface\ReturnFormatter{
  public function prepare($loadData, &$methodName, &$methodData) {
    return 'ERROR_RETURN_FORMATTER_VALIDATE';
  }
  public function format($methodName, $methodData, $Response, $ErrorStore) {
    return '';
  }
}