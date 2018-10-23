<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

class iReturnFormatterTest extends TestCase {
  
  public function testTemp() {
    $this->assertEquals( true, true);
  }
  public function testSuccessReturnFormatter() {
    $Formatter = new \Oploshka\RpcTest\TestReturnFormatter\ReturnFormatterSuccess();
    $methodName = '';
    $methodData = [];
    $result = $Formatter->prepare([], $methodName, $methodData);
    $this->assertEquals( $result, 'ERROR_NOT');
  }
  public function testErrorReturnFormatter() {
    $Formatter = new \Oploshka\RpcTest\TestReturnFormatter\ReturnFormatterError();
    $methodName = '';
    $methodData = [];
    $result = $Formatter->prepare([], $methodName, $methodData);
    $this->assertEquals( $result, 'ERROR_RETURN_FORMATTER_VALIDATE');
  }
}
