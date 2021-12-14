<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcTestHelper\MethodBase\MethodBase;
use Oploshka\RpcTestHelper\MethodBase\MethodBaseRequest;

class RpcMethodClassTest extends TestCase {
  
  public function testBaseReturnData() {
    $rpcMethod = new MethodBase();
    $data = $rpcMethod->getRpcMethodDataObj();
    $this->assertEquals($data,  null);
    
    $data = new MethodBaseRequest();
    $rpcMethod->setRpcMethodDataObj($data);
  
    $rpcMethod->run();
    $rpcResponse = $rpcMethod->getRpcMethodResponseObj();
  
    $this->assertEquals($rpcResponse->getErrorCode(),  'ERROR_DEFAULT');
  }
  
}
