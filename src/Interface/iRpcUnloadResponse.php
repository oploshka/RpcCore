<?php

namespace Oploshka\RpcInterface;

interface iRpcUnloadResponse {
  public function unload(iRpcResponse $rpcResponse, ?iRpcRequest $rpcRequest);
}