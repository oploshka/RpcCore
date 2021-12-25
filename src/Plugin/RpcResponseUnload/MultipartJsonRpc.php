<?php

namespace Oploshka\Rpc\Plugin\RpcResponseUnload;

// interface
use Oploshka\RpcContract\iRpcUnloadResponse;
use Oploshka\RpcContract\iRpcResponse;
use Oploshka\RpcContract\iRpcRequest;
//
use Oploshka\Rpc\Plugin\RpcCodec\RpcCodecJson;
use Oploshka\Rpc\Plugin\RpcResponseStructure\MultipartJsonRpcResponse;

class MultipartJsonRpc implements iRpcUnloadResponse {
  
  private RpcCodecJson              $codec;
  private MultipartJsonRpcResponse  $formatter;
  
  public function __construct() {
    $this->formatter  = new MultipartJsonRpcResponse();
    $this->codec      = new RpcCodecJson();
  }
  
  /**
   * @inheritDoc
   */
  public function unload(iRpcResponse $rpcResponse, ?iRpcRequest $rpcRequest = null) {
    $data = $this->formatter->encode($rpcResponse, $rpcRequest);
    $res = $this->codec->encode($data);
    echo $res;
  }

}