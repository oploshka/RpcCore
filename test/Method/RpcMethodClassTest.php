<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcExample\Method\Base\BaseExample;
use Oploshka\RpcExample\Method\Base\BaseExampleRequest;

class RpcMethodClassTest extends TestCase {
  
  public function testBaseReturnData() {
    $rpcMethod = new BaseExample();
    $data = $rpcMethod->getRpcMethodDataObj();
    $this->assertEquals($data,  null);
    
    $data = new BaseExampleRequest(['login' => 'test', 'password' => 'user']);
    $rpcMethod->setRpcMethodDataObj($data);
  
    $rpcMethod->run();
    $rpcResponse = $rpcMethod->getRpcMethodResponseObj();
  
    $this->assertEquals($rpcResponse->getErrorCode(),  'ERROR_DEFAULT');
  }
  
  public function testInitData() {
    $rpcMethod = new BaseExample();
    $data = $rpcMethod->getRpcMethodDataObj();
    $this->assertEquals($data,  null);
    
    $data = new BaseExampleRequest(['login' => 'test', 'password' => 'user']);
    $rpcMethod->setRpcMethodDataObj($data);
  
    $rpcMethod->run();
    $rpcResponse = $rpcMethod->getRpcMethodResponseObj();
  
    $this->assertEquals($rpcResponse->getErrorCode(),  'ERROR_DEFAULT');
  }
  
}
