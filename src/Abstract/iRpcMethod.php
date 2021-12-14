<?php

namespace Oploshka\RpcAbstract;

use Oploshka\Rpc\RpcResponse;

abstract class iRpcMethod implements \Oploshka\RpcInterface\iRpcMethod {
  // static
  public static function description(): string { return ''; }
  
  //
  private RpcResponse $rpcResponse;
  // protected $Data;
  
  
  public function __construct(){
    $this->rpcResponse = new RpcResponse();
  }

  
  abstract public function run();
  
  // TODO fix magic method
  public final function getRpcMethodDataObj()  {
    return $this->Data;
  }
  public final function setRpcMethodDataObj($data)  {
    return $this->Data = $data;
  }
  public final function getRpcMethodResponseObj() :RpcResponse  {
    return $this->rpcResponse;
  }
  
  // сокращения
  protected function setData(string $key, $value) :iRpcMethod{
    $this->rpcResponse->setData($key, $value);
    return $this;
  }
  
  // сокращения по ошибкам
  protected final function setErrorCode(string $code) :iRpcMethod{
    $this->rpcResponse->setErrorCode($code);
    return $this;
  }
  protected final function setErrorMessage(string $message) :iRpcMethod{
    $this->rpcResponse->setErrorMessage($message);
    return $this;
  }
  protected final function setErrorData(array $data) :iRpcMethod{
    $this->rpcResponse->setErrorData($data);
    return $this;
  }

}
