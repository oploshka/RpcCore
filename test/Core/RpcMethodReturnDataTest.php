<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

class RpcMethodReturnDataTest extends TestCase {
  
  public function testBaseReturnData() {
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $response = $Rpc->runMethod( new \Oploshka\Rpc\RpcMethodInfo([
      'methodName' => 'BaseReturnData'
    ]) );
  
    $this->assertEquals($response->getErrorCode(),  'ERROR_NO');
    $this->assertEquals($response->getData(),  [
      'methodName' => 'MethodTest2'
    ]);
  }
  
  public function testReplaceReturnData() {
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $response = $Rpc->runMethod( new \Oploshka\Rpc\RpcMethodInfo([
      'methodName' => 'ReplaceReturnData'
    ]) );
  
    $this->assertEquals($response->getErrorCode(),  'ERROR_NO');
    $this->assertEquals($response->getData(),  [
      'test1::string' => 'test string',
      'test1::int' => 1,
    ]);
  }
  
  public function testReturnRequestSchemaData() {
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();

    //
    $response = $Rpc->runMethod(
      new \Oploshka\Rpc\RpcMethodInfo([
        'methodName' => 'ReturnRequestSchemaData'
      ])
    );
    $this->assertEquals($response->getErrorCode(),  'ERROR_NO');
    $this->assertEquals($response->getData(),  [
      'string' => null,
      'int'    => null,
      'float'  => null,
      'origin' => null,
    ]);
    
    //
    $response = $Rpc->runMethod(
      new \Oploshka\Rpc\RpcMethodInfo([
        'methodName'  => 'ReturnRequestSchemaData',
        'data'        => [
          'string' => 'testString',
          'int'    => 1235,
          'float'  => 10.4,
          'origin' => [
            'test' => 'array'
          ],
        ]
      ])
    );
    $this->assertEquals($response->getErrorCode(),  'ERROR_NO');
    $this->assertEquals($response->getData(),  [
      'string' => 'testString',
      'int'    => 1235,
      'float'  => 10.4,
      'origin' => [
        'test' => 'array'
      ],
    ]);
  }
}
