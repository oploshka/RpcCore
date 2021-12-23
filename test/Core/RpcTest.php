<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcTestHelper\MethodBase\MethodBase;
use Oploshka\RpcTestHelper\MethodBase\MethodBaseRequest;

class RpcTest extends TestCase {
  
  public function test_runMethodByObject() {
  
    $rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
  
    $data = ['login' => 'test', 'password' => 'user'];
    $rpcResponse = $rpc->runMethodByObject('MethodBase', new MethodBaseRequest($data));
  
    $this->assertEquals( $rpcResponse->getErrorCode(), 'ERROR_DEFAULT');
    $this->assertEquals( $rpcResponse->getData() , $data);
  }
  
}
