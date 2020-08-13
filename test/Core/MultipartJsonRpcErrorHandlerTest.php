<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

class MultipartJsonRpcErrorHandlerTest extends TestCase {

  public function test_MultipartJsonRpc_v0_1__BasicRequest() {
  
    $Rpc = \Oploshka\RpcTestHelper\Helper::getRpc();

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

    $returnJson = $Rpc->startProcessingRequest(false);
    $returnObj = (array)json_decode($returnJson, true);
    $this->assertEquals( $returnObj['response']['error']['code'], 'ERROR_NO_METHOD');
  }

}
