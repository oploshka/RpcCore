<?php

namespace Oploshka\RpcContract;

interface iRpcUnloadResponse {
  
  /**
   * @param iRpcResponse $rpcResponse
   * @param iRpcRequest|null $rpcRequest
   * @throws \Exception
   */
  public function unload(iRpcResponse $rpcResponse, ?iRpcRequest $rpcRequest);
}