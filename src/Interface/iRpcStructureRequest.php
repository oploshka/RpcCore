<?php

namespace Oploshka\RpcInterface;

/*
 * Интерфейс определяющий какая структура данных получена и как с ней работать
 * например: RPC 1.0, RPC 2.0
 *
 **/
interface iRpcStructureRequest {
  /*
   * @param string|object|array $str
   *
   * @return \Oploshka\Rpc\RpcMethodInfo
   */
  public function decode($str);
  
  /*
   * @param \Oploshka\Rpc\RpcMethodInfo $RpcMethodInfoObj
   *
   * @return \Oploshka\Rpc\RpcResponse
   **/
  public function encode($RpcMethodInfoObj);
}
