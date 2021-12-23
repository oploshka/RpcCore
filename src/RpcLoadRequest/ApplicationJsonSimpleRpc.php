<?php

namespace Oploshka\Rpc\RpcLoadRequest;

// interface
use Oploshka\RpcContract\iRpcLoadRequest;
use Oploshka\RpcContract\iRpcRequest;

//
use Oploshka\Rpc\Plugin\RpcGetContent\ApplicationJson;
use Oploshka\Rpc\Plugin\RpcCodec\RpcCodecJson;
use Oploshka\Rpc\Plugin\RpcStructureRequest\MultipartJsonRpcRequest;

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