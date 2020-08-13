<?php

namespace Oploshka\Rpc;

class RpcMethodResponse implements \Oploshka\RpcInterface\Response {
  
  /** @var Error  */
  private $error;
  private $data = [];
  
  public function __construct($arr = []) {
    $this->error = new Error();
  }
  
  // getters
  /**
   * @return array
   */
  public function getData(){
    return $this->data;
  }
  /**
   * @return Error
   */
  public function getError(){
    return $this->error;
  }
  public function getErrorCode(){
    return $this->error->getCode();
  }
  public function getErrorMessage(){
    return $this->error->getMessage();
  }
  public function getErrorData(){
    return $this->error->getData();
  }
  
  // setters
  /**
   * @param string $key
   * @param mixed $value
   * @return RpcMethodResponse
   */
  public function setData($key, $value){
    $this->data[$key] = $value;
    return $this;
  }
  
  /**
   * @param Error $error
   * @return RpcMethodResponse
   */
  public function setError($error): RpcMethodResponse {
    $this->error = $error;
    return $this;
  }
  public function setErrorCode($code){
    $this->error->setCode($code);
    return $this;
  }
  public function setErrorMessage($message){
    $this->error->setMessage($message);
    return $this;
  }
  public function setErrorData($data){
    $this->error->setData($data);
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
