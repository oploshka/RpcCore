<?php

namespace Oploshka\RpcTest\TempClass;

class DataLoaderError implements \Oploshka\RpcInterface\DataLoader {
  
  public function load(&$loadData){
    return 'ERROR_DATA_LOAD_NO_REALIZATION';
  }
  
}