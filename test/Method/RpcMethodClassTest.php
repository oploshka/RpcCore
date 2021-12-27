<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use Oploshka\RpcExample\Enum\MethodError;
use PHPUnit\Framework\TestCase;

use Oploshka\RpcExample\Method\Simple\ReturnSimpleData;
use Oploshka\RpcExample\Method\Simple\ReturnSimpleDataRequest;

class RpcMethodClassTest extends TestCase {
  
  public function testBaseReturnData() {
    $rpcMethod = new ReturnSimpleData();
    $data = $rpcMethod->getRpcMethodDataObj();
    $this->assertEquals($data,  null);
    
    $data = new ReturnSimpleDataRequest([]);
    $rpcMethod->setRpcMethodDataObj($data);
  
    $rpcMethod->run();
    $rpcResponse = $rpcMethod->getRpcMethodResponseObj();
  
    $this->assertEquals($rpcResponse->getErrorCode(),  MethodError::ERROR_NO);
  }
  
  public function testInitData() {
    $rpcMethod = new ReturnSimpleData();
    $data = $rpcMethod->getRpcMethodDataObj();
    $this->assertEquals($data,  null);
    
    $data = new ReturnSimpleDataRequest(['login' => 'test', 'password' => 'user']);
    $rpcMethod->setRpcMethodDataObj($data);
  
    $rpcMethod->run();
    $rpcResponse = $rpcMethod->getRpcMethodResponseObj();
  
    $this->assertEquals($rpcResponse->getErrorCode(),  MethodError::ERROR_NO);
  }
  
}
