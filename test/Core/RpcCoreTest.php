<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcTestHelper\MethodBase\MethodBaseRequest;

class RpcCoreTest extends TestCase {
  
  public function testRunMethodByData() {
  
    $rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
  
    $rpcResponse = $rpc->runMethodByData('MethodBase', new MethodBaseRequest());
  
    $this->assertEquals( $rpcResponse->getErrorCode(), 'ERROR_DEFAULT');
    $this->assertEquals( $rpcResponse->getData() , ['login' => 'test', 'password' => 'user']);
  }
  
}
