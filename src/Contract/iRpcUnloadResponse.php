<?php

namespace Oploshka\RpcContract;

interface iRpcUnloadResponse {
  public function unload(iRpcResponse $rpcResponse, ?iRpcRequest $rpcRequest);
}