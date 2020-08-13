<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

/*
 * Тестирование корректного перехвата ошибок в методах
 **/
class RpcMethodErrorTest extends TestCase {
  
  // TODO: попытаться перехватить ошибку
  // public function testInterfaceNotRealization() {
  //   $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
  //   $response = $Rpc->runMethod( new \Oploshka\Rpc\RpcMethodInfo([
  //     'methodName' => 'InterfaceNotRealization'
  //   ]) );
  //
  //   $this->assertEquals( $response->getErrorCode(), 'ERROR_METHOD_RUN');
  //   $this->assertEquals( $response->getErrorMessage(), 'class_implements(): Class \Oploshka\RpcTestHelper\Error\InterfaceNotRealization does not exist and could not be loaded');
  // }
  
  public function testMethodError() {
    // TODO
    $this->assertEquals( true , true);
  }
  
  public function testInterfaceNotRealization() {
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $response = $Rpc->runMethodByRpcRequest(
      new \Oploshka\Rpc\RpcRequest([
        'methodName' => 'RunUnknownFunction'
      ])
    );
    $this->assertEquals( $response->getErrorCode(), 'ERROR_METHOD_RUN');
    $this->assertEquals( $response->getErrorMessage(), 'Call to undefined function Oploshka\RpcTestHelper\Method\Error\ololo()');
  }
}
