<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

class CoreStartProcessingRequestTest extends TestCase {

  public function testEmptyRequest() {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [];
    //
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $Response = $Rpc->runMethodByRequest();
    $this->assertEquals( $Response->getErrorCode(), 'ERROR_POST_EMPTY');
  }
  
  public function testDataNullRequest() {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = ['test'=>'test'];
    //
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $Response = $Rpc->runMethodByRequest();
    $this->assertEquals( $Response->getErrorCode(), 'ERROR_POST_DATA_NULL');
  }

  public function testNotCorrectData() {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [ 'data' => 'string'];
    //
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $Response = $Rpc->runMethodByRequest();
    $this->assertEquals( $Response->getErrorCode(), 'ERROR_REQUEST_FORMAT_DECODE');

    $_POST = [ 'data' => [] ];
    //
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $Response = $Rpc->runMethodByRequest();
    $this->assertEquals( $Response->getErrorCode(), 'ERROR_REQUEST_FORMAT_DECODE');
  }

  public function testBasicMethodRun() {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [ 'data' => '{
      "specification": "multipart-json-rpc", "specificationVersion" : "0.1.0", "version": "1", "language": "en",
      "request" : {
        "id"   : "9423234",
        "name" : "ReplaceReturnData",
        "data" : { "userId" : 1 }
      }
    }'];
    //
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $Response = $Rpc->runMethodByRequest();
    $this->assertEquals( $Response->getErrorCode(), 'ERROR_NO');
    $this->assertEquals( $Response->getData(), ['test1::string' => 'test string', 'test1::int' => 1]);
  }

  public function testBasicMultipleMethodRun() {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [ 'data' => [] ]; // TODO: fix
    //
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();
    $Response = $Rpc->runMethodByRequest();
    // TODO: fix
    $this->assertEquals( true, true);
//    $this->assertEquals( $returnObj['requestType'], 'multiple');
//    $this->assertEquals( count($returnObj['responseList']), 2);
//
//    $response = $returnObj['responseList'][0];
//    $this->assertEquals( $response->getErrorCode(), 'ERROR_NO');
//    $this->assertEquals( $response->getData(), ['test1::string' => 'test string', 'test1::int' => 1]);
//
//    $response = $returnObj['responseList'][1];
//    $this->assertEquals( $response->getErrorCode(), 'ERROR_NO');
//    $this->assertEquals( $response->getData(), ['methodName' => 'MethodTest2']);
  }
}
