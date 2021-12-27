<?php

namespace Oploshka\RpcContract;

/*
 * Интерфейс определяющий какая структура данных получена и как с ней работать
 * например: JSON-RPC-1.0, JSON-RPC-RPC 2.0
 **/
interface iRpcStructureRequest {
  public function decode($str) :iRpcRequest;
  public function encode(iRpcRequest $rpcRequest);
}
