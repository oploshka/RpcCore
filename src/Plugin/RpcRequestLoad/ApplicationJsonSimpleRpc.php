<?php

namespace Oploshka\Rpc\Plugin\RpcRequestLoad;

// interface
use Oploshka\RpcContract\iRpcLoadRequest;
use Oploshka\RpcContract\iRpcRequest;

//
use Oploshka\Rpc\Plugin\RpcContentGet\ApplicationJson;
use Oploshka\Rpc\Plugin\RpcCodec\RpcCodecJson;
use Oploshka\Rpc\Plugin\RpcRequestStructure\MultipartJsonRpcRequest;

class ApplicationJsonSimpleRpc implements iRpcLoadRequest {
  
  private ApplicationJson $getContent;
  private RpcCodecJson $codec;
  private MultipartJsonRpcRequest $requestStructureParser;
  
  public function __construct() {
    $this->getContent = new ApplicationJson();
    $this->codec = new RpcCodecJson();
    $this->requestStructureParser = new MultipartJsonRpcRequest();
  }
  
  public function load(): iRpcRequest {
    $content = $this->getContent->load();
    $data = $this->codec->decode($content);
    return $this->requestStructureParser->decode($data);
  }
  
}