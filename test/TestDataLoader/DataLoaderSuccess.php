<?php

namespace Oploshka\RpcTest\TestDataLoader;

class DataLoaderSuccess implements \Oploshka\Rpc\iDataLoader {
  
  public function load(&$loadData){
    $loadData['method'] = 'testMethod';
    $loadData['params'] = ['data1' => 'test'];
    return 'ERROR_NOT';
  }
  
}