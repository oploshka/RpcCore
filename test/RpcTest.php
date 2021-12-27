<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcExample\Method\Simple\BaseExampleRequest;

class RpcTest extends TestCase {
  
  public function test_runMethodByObject() {
  
    $rpc = \Oploshka\RpcExample\RpcServer::getRpc();
  
    $data = ['login' => 'test', 'password' => 'user'];
    $rpcResponse = $rpc->runMethodByObject('MethodBase', new BaseExampleRequest($data));
  
    $this->assertEquals( $rpcResponse->getErrorCode(), 'ERROR_DEFAULT');
    $this->assertEquals( $rpcResponse->getData() , $data);
  }
  
}
