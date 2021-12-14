<?php

namespace Oploshka\RpcAbstract;

use Oploshka\Rpc\RpcResponse;

abstract class Method implements \Oploshka\RpcInterface\Method {
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
  protected function setData(string $key, $value) :Method{
    $this->RpcResponse->setData($key, $value);
    return $this;
  }
  
  // сокращения по ошибкам
  protected final function setErrorCode(string $code) :Method{
    $this->RpcResponse->setErrorCode($code);
    return $this;
  }
  protected final function setErrorMessage(string $message) :Method{
    $this->RpcResponse->setErrorMessage($message);
    return $this;
  }
  protected final function setErrorData(array $data) :Method{
    $this->RpcResponse->setErrorData($data);
    return $this;
  }

}
