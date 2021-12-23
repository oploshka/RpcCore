<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcTestHelper\MethodBase\MethodBase;
use Oploshka\RpcTestHelper\MethodBase\MethodBaseRequest;

class RpcCoreTest extends TestCase {
  
  public function test_createRpcMethodClass() {
    $rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    
    $dataNotFilter = ['login' => 'test', 'password' => 'user', 'unnecessary' => 'bla bla bla', 'test' => 112 ];
    $dataFiltered  = ['login' => 'test', 'password' => 'user'];
    
    $rpcMethodClass = $rpc->createRpcMethodClass('MethodBase', $dataNotFilter);
    /**
     * @var $data MethodBaseRequest
     */
    $data = $rpcMethodClass->getRpcMethodDataObj();
  
    $this->assertEquals( $data->getLogin()    , 'test');
    $this->assertEquals( $data->getPassword() , 'user');
    $this->assertEquals( $data->getData()     , $dataFiltered);
  }
  
}
