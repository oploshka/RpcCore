<?php

namespace Oploshka\RpcAbstract;

use Oploshka\Rpc\RpcResponse;

abstract class iRpcMethod implements \Oploshka\RpcInterface\iRpcMethod {
  // static
  public static function description(): string { return ''; }
  
  //
  private RpcResponse $RpcResponse;
  // protected $Data;

  public function __construct(){
    $this->RpcResponse = new RpcResponse();
  }
  
  abstract public function run();
  
  // TODO fix magic method
  public final function getDataObj()  {
    return $this->Data;
  }
  // public final function setRpcData($data)  {
  //   return $this->Data = $data;
  // }
  
  // сокращения
  protected function setData(string $key, $value) :iRpcMethod{
    $this->RpcResponse->setData($key, $value);
    return $this;
  }
  
  // сокращения по ошибкам
  protected final function setErrorCode(string $code) :iRpcMethod{
    $this->RpcResponse->setErrorCode($code);
    return $this;
  }
  protected final function setErrorMessage(string $message) :iRpcMethod{
    $this->RpcResponse->setErrorMessage($message);
    return $this;
  }
  protected final function setErrorData(array $data) :iRpcMethod{
    $this->RpcResponse->setErrorData($data);
    return $this;
  }

}
