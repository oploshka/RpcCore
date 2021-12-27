<?php declare(strict_types=1);

namespace Oploshka\RpcTest\Plugin\RpcRequestLoad;

use Oploshka\Rpc\Plugin\RpcRequestLoad\MultipartJsonRpc as RequestLoad_MultipartJsonRpc;
use PHPUnit\Framework\TestCase;

class MultipartJsonRpcTest extends TestCase {
  
  public function testBaseReturnData() {
    $requestLoad = new RequestLoad_MultipartJsonRpc();
  
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [
        'data' => '{
        "specification": "multipart-json-rpc",
        "specificationVersion" : "0.1.0",
        
        "version": "1",
        "language": "en",
        
        "request" : {
          "id"   : "basicRequestId",
          "name" : "ReturnRequestSchemaData",
          "data" : {
            "string": "1 test String",
            "int": 1
          }
        }
      }',
    ];
    
    $rpcRequest = $requestLoad->load();
    $this->assertEquals('basicRequestId', $rpcRequest->getRequestId());
    $this->assertEquals('ReturnRequestSchemaData', $rpcRequest->getMethodName());
    $this->assertEquals([ "string" => "1 test String", "int" => 1], $rpcRequest->getData());
  }
}
