<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\ReformDebug;
use Oploshka\RpcInterface\iRpcMethodStorage;
use Oploshka\RpcInterface\iRpcLoadRequest;

class RpcCore {
  
  // валидация данных
  protected \Oploshka\Reform\Reform $Reform;
  // хранилище методов
  protected iRpcMethodStorage $RpcMethodStorage;
  // обработка данных запроса/ответа
  protected iRpcLoadRequest $RpcLoadRequest;
  
  // // getters
  // public function getReform()               { return $this->Reform;               }
  // public function getRpcMethodStorage()     { return $this->RpcMethodStorage;     }
  // public function getRpcRequestLoad()       { return $this->RpcRequestLoad;       }
  
  // // setters TODO: fix
  // public function setReform($obj)               { return $this->Reform           = $obj; }
  // public function setRpcMethodStorage($obj)     { return $this->RpcMethodStorage = $obj; }


  public function __construct(array $obj = []) {
    $this->Reform               = $obj['Reform']                ?? new ReformDebug();
    $this->RpcMethodStorage     = $obj['RpcMethodStorage']      ?? new RpcMethodStorage();
  }
  
  
}
