<?php

namespace Oploshka\RpcInterface;

// TODO: need optimization
interface FileLoader {
  
  /**
   * start load data
   * and return true for success load or error string code
   **/
  public function load(&$loadData);
  
}
