<?php declare(strict_types=1);

namespace Oploshka\RpcTest\MethodRun;

use Oploshka\RpcExample\Enum\MethodName;
use PHPUnit\Framework\TestCase;


/*
 * Тестирование корректного перехвата ошибок в методах
 **/
class RpcErrorMethodRunTest extends TestCase {
  
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
  
  
  public function testErrorMethod_InterfaceNotRealization() {
    $rpc = \Oploshka\RpcExample\RpcErrorServer::getRpc();
    $response = $rpc->runRpcMethod(MethodName::ERROR__InterfaceNotRealization, []);
    $this->assertEquals( $response->getErrorCode(), 'ERROR_METHOD_RUN');
    $this->assertEquals( $response->getErrorMessage(), 'class_implements(): Class \Oploshka\RpcTestHelper\Error\InterfaceNotRealization does not exist and could not be loaded');
  }
  
  public function testErrorMethod_RunUnknownFunction() {
    $rpc = \Oploshka\RpcExample\RpcErrorServer::getRpc();
    $response = $rpc->runRpcMethod(MethodName::ERROR__RunUnknownFunction, []);
    $this->assertEquals( $response->getErrorCode(), 'ERROR_METHOD_RUN');
    $this->assertEquals( $response->getErrorMessage(), 'Call to undefined function Oploshka\RpcExample\Method\Error\unknownFunction()');
  }
}
