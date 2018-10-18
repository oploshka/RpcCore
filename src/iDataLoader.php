<?php

namespace Oploshka\Rpc;

// TODO: need optimization
interface iDataLoader {
  
  /**
   * start load data
   * and return true for success load or error string code
   **/
  public function load(&$methodName, &$methodData);
  
}
