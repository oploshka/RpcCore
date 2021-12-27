<?php

namespace Oploshka\RpcContract;

use Oploshka\Rpc\RpcError;
use Oploshka\Rpc\RpcResponse;

interface iRpcResponse {
  
  // getters
  public function getData() :array;
  public function getError() :RpcError;
  public function getErrorCode() :string;
  public function getErrorMessage() :string;
  public function getErrorData() :array;
  
  // setters
  public function setData(string $key, $value): RpcResponse;
  public function setError(RpcError $error): RpcResponse;
  public function setErrorCode(string $code): RpcResponse ;
  public function setErrorMessage(string $message): RpcResponse;
  public function setErrorData(array $data): RpcResponse;
  public function error(RpcError $error);
}