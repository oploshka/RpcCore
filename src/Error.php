<?php

namespace Oploshka\Rpc;

class Error {
  
  private $code = 'ERROR_DEFAULT';
  private $message = '';
  private $data = [];
  
  public function __construct($arr = []) {
    isset($arr['code']) && $this->setCode($arr['code']);
    isset($arr['message']) && $this->setMessage($arr['message']);
    isset($arr['data']) && $this->setData($arr['data']);
  }
  
  // getters
  
  /**
   * @return string
   */
  public function getCode(): string {
    return $this->code;
  }
  
  /**
   * @return string
   */
  public function getMessage(): string {
    return $this->message;
  }
  
  /**
   * @return array
   */
  public function getData(): array {
    return $this->data;
  }
  
  // setters
  
  /**
   * @param string $code
   * @return Error
   */
  public function setCode(string $code): Error {
    $this->code = $code;
    return $this;
  }
  
  /**
   * @param string $message
   * @return Error
   */
  public function setMessage(string $message): Error {
    $this->message = $message;
    return $this;
  }
  
  /**
   * @param array $data
   * @return Error
   */
  public function setData(array $data): Error {
    $this->data = $data;
    return $this;
  }
  
}
