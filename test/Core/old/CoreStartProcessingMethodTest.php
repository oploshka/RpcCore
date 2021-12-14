<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

/*
 * Тестирование основных ошибок
 **/
class CoreStartProcessingMethodTest extends TestCase {

  public function testNoMethodName() {
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();

    $response = $Rpc->runMethodByRpcRequest( new \Oploshka\Rpc\RpcRequest([
      'methodName' => 'notCreatedMethodName'
    ]) );

    $this->assertEquals( $response->getErrorCode(), 'ERROR_NO_METHOD');
    $this->assertEquals( $response->getData() , []);
    // $this->assertEquals( $response->getLog()  , []);
  }
  
  
  //
  //  public function testMethodTest1() {
  //    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
  //
  //    $response = new \Oploshka\Rpc\RpcMethodResponse();
  //    $response = $Rpc->startProcessingMethod('MethodTest1', [], $response);
  //
  //    $this->assertEquals($response->getErrorCode(),  'ERROR_NO');
  //    $this->assertEquals($response->getData(),  [
  //      'test1::string' => 'test string',
  //      'test1::int' => 1,
  //    ]);
  //    // $this->assertEquals( $response->getLog()  , [ ['test1::string' => 'test string'] ] );
  //  }
  
  
  //public function testApplyPhpSettings() {
  //  $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
  //  $logs = $Rpc->applyPhpSettings();
  //  $this->assertEquals( $logs, true);
  //}
  
}
