<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

class MultipartJsonRpcErrorHandlerTest extends TestCase {

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
          "name" : "MethodNotValid",
          "data" : []
        }
      }',
    ];

    $returnJson = $Rpc->startProcessingRequest();
    $returnObj = (array)json_decode($returnJson, true);
    $this->assertEquals( $returnObj['response']['error']['code'], 'ERROR_METHOD');
  }

}
