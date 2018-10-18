<?php

namespace Oploshka\RpcTest\TestDataLoader;

class DataLoaderError implements \Oploshka\Rpc\iDataLoader {
  
  public function load(&$methodName, &$methodData){
    return 'ERROR_DATA_LOAD_NO_REALIZATION';
  }
  
}