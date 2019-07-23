<?php

namespace Oploshka\RpcDataFormatter;

class MultipartJsonRpc_v0_1 implements \Oploshka\RpcInterface\DataFormatter {

  // TODO: fix
  public function prepare($loadData, &$methodList, &$requestType) {
    $methodList = [];
    /*
    {
      "specification": "multipart-json-rpc",
      "specificationVersion" : "0.1.0",

      "version": "1",
      "language": "en",

      "request" : {
        "id"   : "9423234",
        "name" : "getUserInfo",
        "data" : [ "userId" : 1 ],
      }
    }
    */

    $requestInfo = [
      'specification'         => 'multipart-json-rpc',  // TODO
      'specificationVersion'  => '0.1.0',               // TODO
      'version'               => '1.0.0',               // TODO
      'language'              => 'en',                  // TODO
      'request'               => [
        'id'    => null,
        'name'  => null,
        'data'  => [],
      ],
    ];

    if(!isset( $loadData['request'] ) || !is_array($loadData['request']) ){
      return 'ERROR_NOT_CORRECT_REQUEST';
    }
    if( !isset($loadData['request']['id'])    ){
      $loadData['request']['id'] = null;
    }
    if( !isset($loadData['request']['name'])  ){
      return 'ERROR_NO_METHOD_NAME';
    }
    if( !isset($loadData['request']['data']) || !is_array($loadData['request']['data'])  ){
      return 'ERROR_NOT_CORRECT_REQUEST_DATA';
    }

    $requestInfo['request']['id']   = $loadData['request']['id'];
    $requestInfo['request']['name'] = $loadData['request']['name'];
    $requestInfo['request']['data'] = $loadData['request']['data'];


    if( $requestInfo['request']['name'] !== 'multiple' ){

      $methodList[] = [
        'method'  => $requestInfo['request']['name'],
        'params'  => $requestInfo['request']['data']
      ];
      return 'ERROR_NO';
    }

    return 'ERROR_NOT_SUPPORT_MULTIPLE';

    //$requestType = 'multiple';
    //foreach ($loadData['params'] as $param){
    //  $methodList[] = [
    //    'method' => isset($param['method']) ? $param['method'] : '',
    //    'params' => isset($param['params']) ? $param['params'] : [],
    //  ];
    //}
    //return 'ERROR_NO';
  }

}