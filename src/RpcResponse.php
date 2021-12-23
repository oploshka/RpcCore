<?php

namespace Oploshka\Rpc;

use Oploshka\RpcContract\iRpcResponse;

class RpcResponse implements iRpcResponse {
  
  private RpcError  $Error;
  private array     $data;
  
  public function __construct() {
    $this->Error      = new RpcError();
    $this->data       = [];
  }
  
  
  // getters
  public function getData() :array {
    return $this->data;
  }
  public function getError() :RpcError {
    return $this->Error;
  }
  public function getErrorCode() :string{
    return $this->Error->getCode();
  }
  public function getErrorMessage() :string{
    return $this->Error->getMessage();
  }
  public function getErrorData() :array{
    return $this->Error->getData();
  }
  
  
  // setters
  public function setData(string $key, $value): RpcResponse {
    $this->data[$key] = $value;
    return $this;
  }
  //
  public final function setError(RpcError $error): RpcResponse {
    $this->Error = $error;
    return $this;
  }
  public final function setErrorCode(string $code): RpcResponse {
    $this->Error->setCode($code);
    return $this;
  }
  public final function setErrorMessage(string $message): RpcResponse {
    $this->Error->setMessage($message);
    return $this;
  }
  public final function setErrorData(array $data): RpcResponse {
    $this->Error->setData($data);
    return $this;
  }
  //
  public final function error(RpcError $error) {
    $this->setError($error);
    throw new \Oploshka\RpcException\RpcMethodEndException('');
  }
}

