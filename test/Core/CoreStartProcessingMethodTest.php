<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

/*
 * Тестирование основных ошибок
 **/
class CoreStartProcessingMethodTest extends TestCase {

  //public function testApplyPhpSettings() {
  //  $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
  //  $logs = $Rpc->applyPhpSettings();
  //  $this->assertEquals( $logs, true);
  //}

  public function testNoMethodName() {
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();

    
    $response = $Rpc->runMethodProcessing( new \Oploshka\Rpc\RpcMethodInfo([
      'methodName' => 'notCreatedMethodName'
    ]) );

    $this->assertEquals( $response->getErrorCode(), 'ERROR_NO_METHOD');
    $this->assertEquals( $response->getData() , []);
    // $this->assertEquals( $response->getLog()  , []);
  }
  
  /*
  public function testNoMethod() {
    $Rpc = \Oploshka\RpcHelperTest\Helper::getRpc();

    $response = $Rpc->startProcessingMethod('test', []);
  
    $this->assertEquals( $response->getErrorCode(), 'ERROR_NO_METHOD_INFO');
    $this->assertEquals( $response->getData() , []);
    // $this->assertEquals( $response->getLog()  , []);
  }
  
  public function testMethodTest1() {
    $Rpc = \Oploshka\RpcHelperTest\Helper::getRpc();

    $response = new \Oploshka\Rpc\RpcMethodResponse();
    $response = $Rpc->startProcessingMethod('MethodTest1', [], $response);
  
    $this->assertEquals($response->getErrorCode(),  'ERROR_NO');
    $this->assertEquals($response->getData(),  [
      'test1::string' => 'test string',
      'test1::int' => 1,
    ]);
    // $this->assertEquals( $response->getLog()  , [ ['test1::string' => 'test string'] ] );
  }
  */
}
