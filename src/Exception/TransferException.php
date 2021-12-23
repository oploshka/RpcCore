<?php

namespace Oploshka\RpcException;

class TransferException extends \RuntimeException {
  
  private $data;
  
  public function __construct($message, $data = null)
  {
    $this->data = $data;
    parent::__construct($message);
  }
  
  public function getData(){
    return $this->data;
  }
  
}
