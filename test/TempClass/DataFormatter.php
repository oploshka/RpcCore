<?php

namespace Oploshka\RpcTest\TempClass;

class DataFormatter implements \Oploshka\RpcInterface\DataFormatter {

  public function prepare($loadData, &$methodName, &$methodData) {

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

    if(!isset( $loadData['method'], $loadData['params'] ) ){ return 'ERROR_NOT_CORRECT_DATA'; }

    $methodName = $loadData['method'];
    $methodData = $loadData['params'];

    return 'ERROR_NOT';
  }
  
}