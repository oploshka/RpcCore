<?php

namespace Oploshka\Rpc;

// TODO: need optimization
interface DataLoaderInterface {
  
  /**
   * start load data data
   * and return???
   *
   **/
  public function load();
  
  /**
   * Get load data
   * 
   * @return load data
   **/
  public function get();
  
  /**
   * Return error load
   */
  public function error();

}
