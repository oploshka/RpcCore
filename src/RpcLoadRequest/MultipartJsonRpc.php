<?php

namespace Oploshka\Rpc\RpcLoadRequest;

// interface
use Oploshka\RpcContract\iRpcLoadRequest;
use Oploshka\RpcContract\iRpcRequest;
//
use Oploshka\Rpc\Plugin\RpcLoadContent\Post_MultipartFormData_Field;
use Oploshka\Rpc\Plugin\RpcStructureRequest\MultipartJsonRpcRequest;

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
