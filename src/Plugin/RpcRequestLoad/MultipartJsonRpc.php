<?php

namespace Oploshka\Rpc\Plugin\RpcRequestLoad;

// interface
use Oploshka\RpcContract\iRpcLoadRequest;
use Oploshka\RpcContract\iRpcRequest;
//
use Oploshka\Rpc\Plugin\RpcContentLoad\Post_MultipartFormData_Field;
use Oploshka\Rpc\Plugin\RpcRequestStructure\MultipartJsonRpcRequest;

class MultipartJsonRpc implements iRpcLoadRequest {
  
  private Post_MultipartFormData_Field $contentLoad;
  private MultipartJsonRpcRequest      $requestStructureParser;
  
  public function __construct(){
    $this->contentLoad            = new Post_MultipartFormData_Field('data');
    $this->requestStructureParser = new MultipartJsonRpcRequest();
  }
  
  public function load() :iRpcRequest {
    $data = $this->contentLoad->load();
    return $this->requestStructureParser->decode($data);
  }
  
}
