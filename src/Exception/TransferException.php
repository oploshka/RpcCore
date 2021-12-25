<?php

namespace Oploshka\RpcException;

class TransferException extends \RuntimeException {
  
  private string $strCode;
  private array $data;
  
  public function __construct($code, array $data = [], $message = '')
  {
    $this->data = $data;
    $this->strCode = $code;
    parent::__construct($message);
  }
  
  public function getData():array{
    return $this->data;
  }
  public function getStrCode():string{
    return $this->strCode;
  }
  
}
