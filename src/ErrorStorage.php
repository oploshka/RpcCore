<?php

namespace Oploshka\Rpc;

class ErrorStorage implements iErrorStorage {
  
  private $error = [];
  
  public function __construct() {
  }
  
  /**
   * 
   * @param string $name
   * @param object $data
   * - message    -> error message,
   * - code       -> error code
   * - httpCode   -> https://ru.wikipedia.org/wiki/Список_кодов_состояния_HTTP
   * - ...
   *
   * @throws \Exception
   */
  public function add($name, $data){
    // todo: add validate
    $this->error[$name] = $data;
  }
  
  /**
   * @return array || false
   */
  public function get($name) {
    if( !isset($this->error[$name]) ){
      return false;
    }
    return $this->error[$name];
  }
}
