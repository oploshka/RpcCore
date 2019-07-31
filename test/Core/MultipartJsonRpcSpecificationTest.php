<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

class MultipartJsonRpcSpecificationTest extends TestCase {

  public function test_MultipartJsonRpc_v0_1__BasicRequest() {

    // init MultipartJsonRpc_v0_1
    $rpcInitData = [
      'methodStorage'   => \Oploshka\RpcHelperTest\Helper::getRpcMethodStorage()    ,
      'reform'          => \Oploshka\RpcHelperTest\Helper::getRpcReform()           ,
      'dataLoader'      => new \Oploshka\RpcDataLoader\PostMultipartFieldJson()     ,
      'dataFormatter'   => new \Oploshka\RpcDataFormatter\MultipartJsonRpc_v0_1()   ,
      'returnFormatter' => new \Oploshka\RpcReturnFormatter\MultipartJsonRpc_v0_1() ,
      'responseClass'   => \Oploshka\RpcHelperTest\Helper::getResponseClass()       ,
    ];
    $Rpc = new \Oploshka\Rpc\Core($rpcInitData);
    $Rpc->applyPhpSettings();

    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [
      'data' => '{
        "specification": "multipart-json-rpc",
        "specificationVersion" : "0.1.0",
        
        "version": "1",
        "language": "en",
        
        "request" : {
          "id"   : "basicRequestId",
          "name" : "MethodTest1",
          "data" : []
        }
      }',
    ];

    $returnJson = $Rpc->startProcessingRequest();
    $returnObj = (array) json_decode($returnJson, true);

    $this->assertEquals( $returnObj['specification']        , 'multipart-json-rpc');
    $this->assertEquals( $returnObj['specificationVersion'] , '0.1.0');
    $this->assertEquals( $returnObj['version']              , '1.0.0');
    $this->assertEquals( $returnObj['language']             , 'en');
    $this->assertEquals( $returnObj['response']['error']['code'], 'ERROR_NO');
    $this->assertEquals( $returnObj['response']['requestId'], 'basicRequestId');
    $this->assertEquals( $returnObj['response']['data']     , ['test1::string' => 'test string', 'test1::int' => 1]);
  }


  public function test_MultipartJsonRpc_v0_1__MultipleRequest() {

    // init MultipartJsonRpc_v0_1
    $rpcInitData = [
      'methodStorage'   => \Oploshka\RpcHelperTest\Helper::getRpcMethodStorage()    ,
      'reform'          => \Oploshka\RpcHelperTest\Helper::getRpcReform()           ,
      'dataLoader'      => new \Oploshka\RpcDataLoader\PostMultipartFieldJson()     ,
      'dataFormatter'   => new \Oploshka\RpcDataFormatter\MultipartJsonRpc_v0_1()   ,
      'returnFormatter' => new \Oploshka\RpcReturnFormatter\MultipartJsonRpc_v0_1() ,
      'responseClass'   => \Oploshka\RpcHelperTest\Helper::getResponseClass()       ,
    ];
    $Rpc = new \Oploshka\Rpc\Core($rpcInitData);
    $Rpc->applyPhpSettings();

    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [
      'data' => '{
        "specification": "multipart-json-rpc",
        "specificationVersion" : "0.1.0",
        
        "version": "1",
        "language": "en",
        
        "request" : {
          "id"   : "multipleRequestId",
          "name" : "multiple",
          "data" : {
            "multiple": [
              { "id"   : "testRequestId_2", "name" : "MethodTest1", "data" : [] },
              { "id"   : "testRequestId_1", "name" : "MethodTest2", "data" : [] }
            ]
          }
        }
      }',
    ];

    $returnJson = $Rpc->startProcessingRequest();
    $returnObj = (array) json_decode($returnJson, true);

    $this->assertEquals( $returnObj['specification']        , 'multipart-json-rpc');
    $this->assertEquals( $returnObj['specificationVersion'] , '0.1.0');
    $this->assertEquals( $returnObj['version']              , '1.0.0');
    $this->assertEquals( $returnObj['language']             , 'en');
    $this->assertEquals( $returnObj['response']['error']['code'], 'ERROR_NO');
    $this->assertEquals( $returnObj['response']['requestId'], 'multipleRequestId');
    $this->assertEquals( $returnObj['response']['data']     , ['multiple' => [
      [
        'requestId' => 'testRequestId_2',
        'error' => ['code' => 'ERROR_NO'],
        'data'  => ['test1::string' => 'test string', 'test1::int' => 1]
      ],
      [
        'requestId' => 'testRequestId_1',
        'error' => ['code' => 'ERROR_NO'],
        'data'  => ['methodName' => 'MethodTest2']
      ]
    ] ]);
  }

  public function test_MultipartJsonRpc_v0_1__TestMethodData() {

    // init MultipartJsonRpc_v0_1
    $rpcInitData = [
      'methodStorage' => \Oploshka\RpcHelperTest\Helper::getRpcMethodStorage(),
      'reform' => \Oploshka\RpcHelperTest\Helper::getRpcReform(),
      'dataLoader' => new \Oploshka\RpcDataLoader\PostMultipartFieldJson(),
      'dataFormatter' => new \Oploshka\RpcDataFormatter\MultipartJsonRpc_v0_1(),
      'returnFormatter' => new \Oploshka\RpcReturnFormatter\MultipartJsonRpc_v0_1(),
      'responseClass' => \Oploshka\RpcHelperTest\Helper::getResponseClass(),
    ];
    $Rpc = new \Oploshka\Rpc\Core($rpcInitData);
    $Rpc->applyPhpSettings();

    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [
      'data' => '{
        "specification": "multipart-json-rpc",
        "specificationVersion" : "0.1.0",
        
        "version": "1",
        "language": "en",
        
        "request" : {
          "id"   : "basicRequestId",
          "name" : "MethodTestData",
          "data" : {
            "string": "1 test String",
            "int": 1
          }
        }
      }',
    ];

    $returnJson = $Rpc->startProcessingRequest();
    $returnObj = (array)json_decode($returnJson, true);

    $this->assertEquals( $returnObj['response']['error']['code'], 'ERROR_NO');
    $this->assertEquals($returnObj['response']['data']['string'], '1 test String');
  }
}
