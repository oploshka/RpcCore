<?php

namespace Oploshka\Rpc;

class RpcError {
  
  private string $code;
  private string $message;
  private array  $data;
  
  public function __construct(string $code = 'ERROR_DEFAULT', string $message = '', array $data = []) {
    $this->code     = $code;
    $this->message  = $message;
    $this->data     = $data;
  }
  
  // getters
  public function getCode(): string {
    return $this->code;
  }
  public function getMessage(): string {
    return $this->message;
  }
  public function getData(): array {
    return $this->data;
  }
  
  // setters
  public function setCode(string $code): RpcError {
    $this->code = $code;
    return $this;
  }
  public function setMessage(string $message): RpcError {
    $this->message = $message;
    return $this;
  }
  public function setData(array $data): RpcError {
    $this->data = $data;
    return $this;
  }
  
}
