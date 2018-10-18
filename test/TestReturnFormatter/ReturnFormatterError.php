<?php

namespace Oploshka\RpcTest\TestReturnFormatter;

class ReturnFormatterError implements \Oploshka\Rpc\iReturnFormatter{
  public function validate($methodName, $methodData) {
    return 'ERROR_RETURN_FORMATTER_VALIDATE';
  }
  public function format($methodName, $methodData, $Response, $ErrorStore) {
    return '';
  }
}