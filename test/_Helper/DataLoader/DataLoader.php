<?php

namespace Oploshka\RpcHelperTest\DataLoader;

class DataLoader implements \Oploshka\RpcInterface\DataLoader {
  
  public function load(&$loadData){

    if( !isset($_POST['data']) ){ return 'ERROR_POST_DATA_NULL'; }
    $loadData = $_POST['data'];
    /*
    [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1',
      'language'              => 'ru',
      'method'                => 'testMethod1',
      'params'                => [
        'data1' => 'test'
      ],
    ];
    */

    return 'ERROR_NO';
  }
  
}