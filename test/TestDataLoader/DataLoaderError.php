<?php

namespace Oploshka\RpcTest\TestDataLoader;

class DataLoaderError implements \Oploshka\Rpc\iDataLoader {
  
  public function load(&$loadData){
    return 'ERROR_DATA_LOAD_NO_REALIZATION';
  }
  
}