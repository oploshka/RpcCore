<?php

namespace Oploshka\RpcTest\TestDataLoader;

class DataLoaderSuccess implements \Oploshka\Rpc\iDataLoader {
  
  public function load(&$methodName, &$methodData){
    $methodName = 'testMethod';
    $methodData = ['data1' => 'test'];
    return true;
  }
  
}