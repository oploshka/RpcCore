<?php

namespace Oploshka\RpcTest\TempClass;

class DataLoaderSuccess implements \Oploshka\RpcInterface\DataLoader {
  
  public function load(&$loadData){
    $loadData['method'] = 'testMethod';
    $loadData['params'] = ['data1' => 'test'];
    return 'ERROR_NOT';
  }
  
}