<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

class CoreStartProcessingMethodTest extends TestCase {

  //public function testApplyPhpSettings() {
  //  $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
  //  $logs = $Rpc->applyPhpSettings();
  //  $this->assertEquals( $logs, true);
  //}

  public function testNoMethodName() {
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();

    $response = $Rpc->startProcessingMethod('', []);

    $this->assertEquals( $response->getError(), 'ERROR_NO_METHOD_NAME');
    $this->assertEquals( $response->getData() , []);
    // $this->assertEquals( $response->getLog()  , []);
  }
  
  public function testNoMethod() {
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();

    $response = $Rpc->startProcessingMethod('test', []);
  
    $this->assertEquals( $response->getError(), 'ERROR_NO_METHOD_INFO');
    $this->assertEquals( $response->getData() , []);
    // $this->assertEquals( $response->getLog()  , []);
  }
  
  public function testMethodTest1() {
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();

    $response = new Response();
    $response = $Rpc->startProcessingMethod('methodTest1', [], $response);
  
    $this->assertEquals($response->getError(),  'ERROR_NOT');
    $this->assertEquals($response->getData(),  [
      'test1::string' => 'test string',
      'test1::int' => 1,
    ]);
    // $this->assertEquals( $response->getLog()  , [ ['test1::string' => 'test string'] ] );
  }
}
