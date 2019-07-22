<?php

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

class CoreCreateTest extends TestCase {

  public function testCreate_MultipartJsonRpc_v0_1() {

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
        "specificationVersion": "0.1",
        "language": "ru",
        "method": "MethodTest1",
        "params": {
          "data1": "test"
        }
      }',
    ];

    $returnObj = $Rpc->startProcessingRequest();
    $this->assertEquals( $returnObj, 'single');
    $response = $returnObj['responseList'][0];
    $this->assertEquals( $response->getError(), 'ERROR_POST_DATA_NULL');
  }

}
