<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\Reform;
use Oploshka\Reform\ReformDebug;
use Oploshka\RpcAbstract\rpcMethod;
// Exception
use Oploshka\RpcException\RpcException;
use Oploshka\RpcException\RpcMethodEndException;
// Interface
use Oploshka\RpcContract\iRpcMethod;
use Oploshka\RpcContract\iRpcMethodRequest;
use Oploshka\RpcContract\iRpcMethodStorage;
use Oploshka\RpcContract\iRpcLoadRequest;
use Oploshka\RpcContract\iRpcRequest;
use Oploshka\RpcContract\iRpcResponse;
use Oploshka\RpcContract\iRpcUnloadResponse;

// use Oploshka\RpcException\ReformException; // TODO: fix

class Rpc extends RpcCore {
  
  /**
   * Запускаем обработку запроса
   * @return iRpcResponse
   */
  public function runMethodByRequest() :iRpcResponse {
    try {
      // получаем данные из запроса
      $rpcRequest = $this->rpcRequestLoad();
    } catch (RpcException $e) {
      $rpcResponseError = new RpcResponse();
      $rpcResponseError->setErrorCode($e->getStrCode());
      $rpcResponseError->setErrorData($e->getData());
      $rpcResponseError->setErrorMessage($e->getMessage());
      return $rpcResponseError;
    }
    
    // TODO: add Trown
    
    return $this->runRpcMethod($rpcRequest->getMethodName(), $rpcRequest->getData());
  }
  
  public function runMethodByObject(string $methodName, object $data) :iRpcResponse {
    // get method info
    $MethodClassName = $this->getRpcMethodClassName($methodName);
    /** @var  $MethodClass rpcMethod */
    $MethodClass = new $MethodClassName();
    $MethodClass->setRpcMethodDataObj($data);
    $MethodClass->run();
    return $MethodClass->getRpcMethodResponseObj();
  }
  
  public function runRpc() {
    try {
      // получаем данные из запроса
      $rpcRequest = $this->rpcRequestLoad();
    } catch (RpcException $e) {
      // TODO: fix
      $rpcResponseError = new RpcResponse();
      $rpcResponseError->setErrorCode($e->getStrCode());
      $rpcResponseError->setErrorData($e->getData());
      $rpcResponseError->setErrorMessage($e->getMessage());
  
      $this->rpcUnloadResponse->unload($rpcResponseError);
      return;
    }
  
    try {
      $rpcResponse = $this->runRpcMethod($rpcRequest->getMethodName(), $rpcRequest->getData());
    } catch (RpcException $e) {
      // TODO: fix
      $rpcResponseError = new RpcResponse();
      $rpcResponseError->setErrorCode($e->getStrCode());
      $rpcResponseError->setErrorData($e->getData());
  
      $this->rpcUnloadResponse->unload($rpcResponseError, $rpcRequest);
      return;
    }
    
    $this->rpcUnloadResponse->unload($rpcResponse, $rpcRequest);
    return;
  }
}
