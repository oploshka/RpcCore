<?php

namespace Oploshka\RpcTest\TempClass;

class DataFormatter implements \Oploshka\RpcInterface\DataFormatter {

  public function prepare($loadData, &$methodList) {
    $methodList = [];
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

    $methodList[] = [
      'method' => $loadData['method'],
      'params'=> $loadData['params']
    ];

    return 'ERROR_NOT';
  }
  
}