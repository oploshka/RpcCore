<?php

namespace Oploshka\Rpc;

// TODO: need optimization
interface DataLoaderInterface {
  
  /**
   * start load data
   * and return error code
   **/
  public function load(&$methodName, &$methodData);
  
}
