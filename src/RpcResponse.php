<?php

namespace Oploshka\Rpc;

class RpcResponse implements \Oploshka\RpcInterface\Response {
  
  /** @var RpcRequest $RpcRequest  */
  private $RpcRequest;
  /** @var Error  */
  private $Error;
  /** @var array */
  private $data = [];
  
  public function __construct($arr = []) {
    $this->RpcRequest = $arr['RpcRequest'] ?? new RpcRequest(['methodName' => 'UNDEFINED']);
    $this->Error      = new Error();
  }
  
  // getters
  public function getRpcRequest(){
    return $this->RpcRequest;
  }
  /** @return array */
  public function getData(){
    return $this->data;
  }
  /**  @return Error */
  public function getError(){
    return $this->Error;
  }
  /**  @return string */
  public function getErrorCode(){
    return $this->Error->getCode();
  }
  /**  @return string */
  public function getErrorMessage(){
    return $this->Error->getMessage();
  }
  /**  @return array */
  public function getErrorData(){
    return $this->Error->getData();
  }
  
  // setters
  /**
   * @param string $key
   * @param mixed $value
   * @return RpcResponse
   */
  public function setData($key, $value){
    $this->data[$key] = $value;
    return $this;
  }
  
  /**
   * @param Error $error
   * @return RpcResponse
   */
  public function setError($error): RpcResponse {
    $this->Error = $error;
    return $this;
  }
  public function setErrorCode($code){
    $this->Error->setCode($code);
    return $this;
  }
  public function setErrorMessage($message){
    $this->Error->setMessage($message);
    return $this;
  }
  public function setErrorData($data){
    $this->Error->setData($data);
    return $this;
  }
  
  /**
   * @param Error $error
   */
  public function error($error = null) {
    $error && $this->error = $error;
    throw new \Oploshka\RpcException\MethodEndException('');
  }
}
