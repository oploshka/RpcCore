<?php

namespace Oploshka\RpcReturnFormatter;

class MultipartJsonRpc_v0_1 implements \Oploshka\RpcInterface\ReturnFormatter{
  
  private $Reform;
  
  function  __construct(){
    $this->Reform = new \Oploshka\Reform\Reform([]);
  }

  public function format($obj) {
    /*[
      'requestType'   => $requestType,
      'responseList' => [ $Response ],
      // 'loadData'     => [],
      // 'methodList'   => [],
    ]*/

    $Response = $obj['responseList'][0];

    $returnObj = [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1',
      "id"                    => null
      'language'              => 'ru',
      "error"   => $Response->getError(), // todo: {"code": -32700, "message": "Parse error"},
      'result'  => $Response->getData(),
    ];

    $returnJson = $this->Reform->item($returnObj, ['type' => 'objToJson']);
    if($returnJson === NULL){
      $returnObj = [
        'specification'         => 'multipart-json-rpc',
        'specificationVersion'  => '0.1',
        'language'              => 'ru',
        "error"   => 'ERROR_CONVERT_RESPONSE_TO_JSON', // todo: {"code": -32700, "message": "Parse error"},
        'result'  => [],
        "id"      => null
      ];
      $returnJson = $this->Reform->item($returnObj, ['type' => 'objToJson']);
    }
    return $returnJson;
  }
}