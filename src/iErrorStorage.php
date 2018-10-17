<?php

namespace Oploshka\Rpc;

// TODO: need optimization
interface iErrorStorage {

  /**
   * Add error
   **/
  public function add($name, $data);

  /**
   * Get error info
   **/
  public function get($name);

}
