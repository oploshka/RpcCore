<?php

namespace Oploshka\RpcInterface;

// TODO: need optimization
interface Error {

  /**
   * Add error
   **/
  public function add($name, $data);

  /**
   * Get error info
   **/
  public function get($name);

}
