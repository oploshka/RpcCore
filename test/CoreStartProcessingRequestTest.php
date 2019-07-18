<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

class CoreStartProcessingRequestTest extends TestCase {

  public function testEmptyRequest() {
    $_POST = [];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $response = $Rpc->startProcessingRequest();
    $this->assertEquals( $response->getError(), 'ERROR_POST_DATA_NULL');
  }

  public function testNotCorrectData() {
    $_POST = [ 'data' => 'string'];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $response = $Rpc->startProcessingRequest();
    $this->assertEquals( $response->getError(), 'ERROR_NOT_CORRECT_DATA');

    $_POST = [ 'data' => [] ];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $response = $Rpc->startProcessingRequest();
    $this->assertEquals( $response->getError(), 'ERROR_NOT_CORRECT_DATA');
  }

  public function testBasicMethodRun() {
    $_POST = [ 'data' => \Oploshka\RpcTest\TempClass\RpcInit::getRpcTestData() ];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $response = $Rpc->startProcessingRequest();
    $this->assertEquals( $response->getError(), 'ERROR_NOT');
    $this->assertEquals( $response->getData(), []);
  }

}
