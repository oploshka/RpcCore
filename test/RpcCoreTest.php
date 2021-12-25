<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcTestHelper\MethodBase\BaseExample;
use Oploshka\RpcTestHelper\MethodBase\BaseExampleRequest;

class RpcCoreTest extends TestCase {
  
  public function test_createRpcMethodClass() {
    $rpc = \Oploshka\RpcExample\RpcServer::getRpc();
    
    $dataNotFilter = ['login' => 'test', 'password' => 'user', 'unnecessary' => 'bla bla bla', 'test' => 112 ];
    $dataFiltered  = ['login' => 'test', 'password' => 'user'];
    
    $rpcMethodClass = $rpc->createRpcMethodClass('MethodBase', $dataNotFilter);
    /**
     * @var $data BaseExampleRequest
     */
    $data = $rpcMethodClass->getRpcMethodDataObj();
  
    $this->assertEquals( $data->getLogin()    , 'test');
    $this->assertEquals( $data->getPassword() , 'user');
    $this->assertEquals( $data->getData()     , $dataFiltered);
  }
  
}
