<?php

namespace Oploshka\RpcRequestValidate;

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
class MultipartJsonRpc_v0_1 implements \Oploshka\RpcInterface\DataFormatter {
  
  public function prepare($loadData, &$methodList, &$requestType) {
    $methodList = [];

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
      // TODO: use throw new Exception();
      return 'ERROR_NOT_CORRECT_REQUEST';
    }
    if( !isset($loadData['request']['id'])    ){
      $loadData['request']['id'] = null;
    }
    if( !isset($loadData['request']['name'])  ){
      // TODO: use throw new Exception();
      return 'ERROR_NO_METHOD_NAME';
    }
    if( !isset($loadData['request']['data']) || !is_array($loadData['request']['data'])  ){
      // TODO: use throw new Exception();
      return 'ERROR_NOT_CORRECT_REQUEST_DATA';
    }

    $requestInfo['request']['id']   = $loadData['request']['id'];
    $requestInfo['request']['name'] = $loadData['request']['name'];
    $requestInfo['request']['data'] = $loadData['request']['data'];
    
    // TODO: return object (class)
    // {
    //   getRequestId
    //   getMethodName
    //   getData
    //   getLanguage
    //   getVersion
    // }
    return $loadData;
  }

}
