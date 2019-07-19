<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

class CoreStartProcessingRequestTest extends TestCase {

  public function testEmptyRequest() {
    $_POST = [];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $returnObj = $Rpc->startProcessingRequest();
    $this->assertEquals( $returnObj['requestType'], 'single');
    $this->assertEquals( count($returnObj['responseList']), 1);
    $response = $returnObj['responseList'][0];
    $this->assertEquals( $response->getError(), 'ERROR_POST_DATA_NULL');
  }

  public function testNotCorrectData() {
    $_POST = [ 'data' => 'string'];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $returnObj = $Rpc->startProcessingRequest();
    $this->assertEquals( $returnObj['requestType'], 'single');
    $this->assertEquals( count($returnObj['responseList']), 1);
    $response = $returnObj['responseList'][0];
    $this->assertEquals( $response->getError(), 'ERROR_NOT_CORRECT_DATA');

    $_POST = [ 'data' => [] ];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $returnObj = $Rpc->startProcessingRequest();
    $this->assertEquals( $returnObj['requestType'], 'single');
    $this->assertEquals( count($returnObj['responseList']), 1);
    $response = $returnObj['responseList'][0];
    $this->assertEquals( $response->getError(), 'ERROR_NOT_CORRECT_DATA');
  }

  public function testBasicMethodRun() {
    $_POST = [ 'data' => \Oploshka\RpcTest\TempClass\RpcInit::getRpcTestData() ];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $returnObj = $Rpc->startProcessingRequest();
    $this->assertEquals( $returnObj['requestType'], 'single');
    $this->assertEquals( count($returnObj['responseList']), 1);
    $response = $returnObj['responseList'][0];
    $this->assertEquals( $response->getError(), 'ERROR_NOT');
    $this->assertEquals( $response->getData(), ['test1::string' => 'test string', 'test1::int' => 1]);
  }

  public function testBasicMultipleMethodRun() {
    $_POST = [ 'data' => \Oploshka\RpcTest\TempClass\RpcInit::getRpcMultipleData() ];
    $Rpc = \Oploshka\RpcTest\TempClass\RpcInit::getRpc();
    $returnObj = $Rpc->startProcessingRequest();
    $this->assertEquals( $returnObj['requestType'], 'multiple');
    $this->assertEquals( count($returnObj['responseList']), 2);

    $response = $returnObj['responseList'][0];
    $this->assertEquals( $response->getError(), 'ERROR_NOT');
    $this->assertEquals( $response->getData(), ['test1::string' => 'test string', 'test1::int' => 1]);

    $response = $returnObj['responseList'][1];
    $this->assertEquals( $response->getError(), 'ERROR_NOT');
    $this->assertEquals( $response->getData(), ['methodName' => 'MethodTest2']);
  }
}
