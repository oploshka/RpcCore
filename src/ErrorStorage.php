<?php

namespace Oploshka\Rpc;

// TODO: need optimization
interface ErrorStorage {

  /**
   * Add error
   **/
  public function add();

  /**
   * Get error info
   **/
  public function get();

}
