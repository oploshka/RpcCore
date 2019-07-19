<?php

namespace Oploshka\RpcInterface;

interface DataLoader {
  
  /**
   * start load data
   * and return true for success load or error string code
   **/
  public function load(&$loadData);
  
}
