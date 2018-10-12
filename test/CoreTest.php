<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

// use Oploshka\Reform\Reform;
// use Oploshka\Rpc\MethodStorage;

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
      'array'         => 'Oploshka\\ReformItem\\ArrayReform'        ,
      'simpleArray'   => 'Oploshka\\ReformItem\\SimpleArrayReform'  ,
    ]);
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
    $Rpc->setHeaderSettings([]); // fix php unit test header send
    return $Rpc;
  }
  
  public function testNoMethodName() {
    $Rpc = $this->getRpc();
    
    $response = $Rpc->run('', []);
    $response = $response->getResponse();
  
    $this->assertEquals($response['error'],  'ERROR_NO_METHOD_NAME', true);
    $this->assertTrue( $response['result'] === []);
    $this->assertTrue( !isset($response['logs']));
  }
  
  public function testNoMethod() {
    $Rpc = $this->getRpc();
    
    $response = $Rpc->run('test', []);
    $response = $response->getResponse();
  
    $this->assertEquals($response['error'],  'ERROR_NO_METHOD_INFO', true);
    $this->assertTrue( $response['result'] === []);
    $this->assertTrue( !isset($response['logs']));
  }
  
  public function testMethodTest1() {
    $Rpc = $this->getRpc();
    
    $response = $Rpc->run('methodTest1', []);
    $response = $response->getResponse();
  
    $this->assertEquals($response['error'],  'ERROR_NOT', true);
    $this->assertEquals($response['result'],  [
      'test1::string' => 'test string',
      'test1::int' => 1,
    ]);
    $this->assertTrue( isset($response['logs']));
    $this->assertEquals($response['logs'],  ['test1::testLog']);
  }
}
