<?php

namespace Oploshka\RpcCore;

use PHPUnit\Framework\TestCase;

// use Oploshka\Reform\Reform;
// use Oploshka\RpcCore\MethodStorage;

class CoreTest extends TestCase {

  private function getRpcReform(){
    return new \Oploshka\Reform\Reform([
      'string'        => 'Oploshka\\ReformItem\\StringReform'       ,
      'int'           => 'Oploshka\\ReformItem\\IntReform'          ,
      'float'         => 'Oploshka\\ReformItem\\FloatReform'        ,
      'email'         => 'Oploshka\\ReformItem\\EmailReform'        ,
      'password'      => 'Oploshka\\ReformItem\\PasswordReform'     ,
      'origin'        => 'Oploshka\\ReformItem\\OriginReform'       ,
      'datetime'      => 'Oploshka\\ReformItem\\DateTimeReform'     ,
      'json'          => 'Oploshka\\ReformItem\\JsonReform'         ,
    ]);
  }
  private function getRpcMethodStorage(){
    $MethodStorage  = new \Oploshka\RpcCore\MethodStorage();
    $MethodStorage->add('methodTest1', 'Oploshka\\RpcCoreTest\\TestMethod\\Test1');
    $MethodStorage->add('methodTest2', 'Oploshka\\RpcCoreTest\\TestMethod\\Test2');
    return $MethodStorage;
  }
  private function getRpcCore(){
    $MethodStorage  = $this->getRpcMethodStorage();
    $Reform         = $this->getRpcReform();
    $RpcCore        = new \Oploshka\RpcCore\Core($MethodStorage, $Reform);
    return $RpcCore;
  }
  
  public function testNoMethodName() {
    $RpcCore = $this->getRpcCore();
    
    $response = $RpcCore->run('', []);
    $response = $response->getResponse();
  
    $this->assertEquals($response['error'],  'ERROR_NOT', true);
    $this->assertTrue( $response['result'] === []);
    $this->assertTrue( !isset($response['logs']));
  }
  
  public function testNoMethod() {
    $RpcCore = $this->getRpcCore();
    
    $response = $RpcCore->run('test', []);
    $response = $response->getResponse();
  
    $this->assertEquals($response['error'],  'ERROR_NOT', true);
    $this->assertTrue( $response['result'] === []);
    $this->assertTrue( !isset($response['logs']));
  }
  
  public function testMethodTest1() {
    $RpcCore = $this->getRpcCore();
    
    $response = $RpcCore->run('methodTest1', []);
    $response = $response->getResponse();
  
    // TODO: fix oploshka/reform item array
    $this->assertEquals($response['error'],  'ERROR_NOT', true);
    $this->assertTrue( $response['result'] !== []);
    $this->assertTrue( !isset($response['logs']));
  }
}
