<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\ReformDebug;

class RpcCore {
  
  // валидация данных
  /** @var \Oploshka\Reform\Reform  */
  protected $Reform;
  // логер
  protected $Logger;
  //
  /** @var \Oploshka\Rpc\RpcMethodStorage  */
  protected $RpcMethodStorage;
  // обработка данных запроса/ответа
  /** @var \Oploshka\RpcRequestLoad\Post_MultipartFormData_Field  */
  protected $RpcRequestLoad;
  /** @var \Oploshka\RpcFormatter\Json  */
  protected $RpcRequestFormatter;
  /** @var \Oploshka\RpcStructure\MultipartJsonRpc_v0_1  */
  protected $RpcRequestStructure;
  /** @var \Oploshka\RpcFormatter\Json  */
  protected $RpcResponseFormatter;
  /** @var \Oploshka\RpcStructure\MultipartJsonRpc_v0_1  */
  protected $RpcResponseStructure;
  
  // getters
  public function getReform()               { return $this->Reform;               }
  public function getRpcMethodStorage()     { return $this->RpcMethodStorage;     }
  //
  public function getRpcRequestLoad()       { return $this->RpcRequestLoad;       }
  public function getRpcRequestFormatter()  { return $this->RpcRequestFormatter;  }
  public function getRpcRequestStructure()  { return $this->RpcRequestStructure;  }
  public function getRpcResponseFormatter() { return $this->RpcResponseFormatter; }
  public function getRpcResponseStructure() { return $this->RpcResponseStructure; }
  
  // setters TODO: fix
  public function setReform($obj)               { return $this->Reform           = $obj; }
  public function setRpcMethodStorage($obj)     { return $this->RpcMethodStorage = $obj; }
  //
  public function setRpcRequestLoad($obj)       { $this->RpcRequestLoad       = $obj; }
  public function setRpcRequestFormatter($obj)  { $this->RpcRequestFormatter  = $obj; }
  public function setRpcRequestStructure($obj)  { $this->RpcRequestStructure  = $obj; }
  public function setRpcResponseFormatter($obj) { $this->RpcResponseFormatter = $obj; }
  public function setRpcResponseStructure($obj) { $this->RpcResponseStructure = $obj; }

  /**
   * Core constructor.
   * @param $obj array
   */
  public function __construct($obj = []) {
    $this->Reform               = $obj['Reform']                ?? new ReformDebug();
    $this->RpcMethodStorage     = $obj['RpcMethodStorage']      ?? new RpcMethodStorage();
    // обработка данных запроса/ответа
    $this->RpcRequestLoad       = $obj['RpcRequestLoad']        ?? new \Oploshka\RpcRequestLoad\Post_MultipartFormData_Field();
    $this->RpcRequestFormatter  = $obj['RpcRequestFormatter' ]  ?? new \Oploshka\RpcFormatter\Json();
    $this->RpcRequestStructure  = $obj['RpcRequestStructure' ]  ?? new \Oploshka\RpcStructure\MultipartJsonRpcRequest();
    $this->RpcResponseFormatter = $obj['RpcResponseFormatter']  ?? new \Oploshka\RpcFormatter\Json();
    $this->RpcResponseStructure = $obj['RpcResponseStructure']  ?? new \Oploshka\RpcStructure\MultipartJsonRpcResponse();
    // TODO: логер
    // $this->Logger                       = $obj['Logger']        ?? new Logger();
  }
  
  
}
