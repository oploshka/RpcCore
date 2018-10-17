<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

// use Oploshka\Reform\Reform;
// use Oploshka\Rpc\MethodStorage;

class CoreTest extends TestCase {

  private function getRpcReform(){
    return new \Oploshka\Reform\Reform();
  }
  private function getRpcMethodStorage(){
    $MethodStorage  = new \Oploshka\Rpc\MethodStorage();
    $MethodStorage->add('methodTest1', 'Oploshka\\RpcTest\\TestMethod\\Test1');
    $MethodStorage->add('methodTest2', 'Oploshka\\RpcTest\\TestMethod\\Test2');
    return $MethodStorage;
  }
  private function getRpc(){
    $MethodStorage  = $this->getRpcMethodStorage();
    $Reform         = $this->getRpcReform();
    $Rpc        = new \Oploshka\Rpc\Core($MethodStorage, $Reform);
    $Rpc->applyPhpSettings();
    return $Rpc;
  }
  
  public function testApplyPhpSettings() {
    $MethodStorage  = $this->getRpcMethodStorage();
    $Reform         = $this->getRpcReform();
    $Rpc        = new \Oploshka\Rpc\Core($MethodStorage, $Reform);
    $logs = $Rpc->applyPhpSettings();
    $this->assertEquals( $logs, true);
  }
  public function testNoMethodName() {
    $Rpc = $this->getRpc();
  
    $response = new Response();
    $response = $Rpc->run('', [], $response);
    
    $this->assertEquals( $response->getError(), 'ERROR_NO_METHOD_NAME');
    $this->assertEquals( $response->getData() , []);
    $this->assertEquals( $response->getLog()  , []);
  }
  
  public function testNoMethod() {
    $Rpc = $this->getRpc();
  
    $response = new Response();
    $response = $Rpc->run('test', [], $response);
  
    $this->assertEquals( $response->getError(), 'ERROR_NO_METHOD_INFO');
    $this->assertEquals( $response->getData() , []);
    $this->assertEquals( $response->getLog()  , []);
  }
  
  public function testMethodTest1() {
    $Rpc = $this->getRpc();
  
    $response = new Response();
    $response = $Rpc->run('methodTest1', [], $response);
  
    $this->assertEquals($response->getError(),  'ERROR_NOT');
    $this->assertEquals($response->getData(),  [
      'test1::string' => 'test string',
      'test1::int' => 1,
    ]);
    $this->assertEquals( $response->getLog()  , [ ['test1::string' => 'test string'] ] );
  }
}
