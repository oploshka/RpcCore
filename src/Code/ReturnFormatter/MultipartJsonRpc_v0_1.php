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

    /*
   {
     "specification": "multipart-json-rpc",
     "specificationVersion" : "0.1.0",

     "version": "1",
     "language": "en",

    "response": {
      "requestId"   : "9423234",
      "error": {
        "code": "ERROR_NO"
      },
      "data": [ "user": USER_CLASS ]
    }
   }
   */


    $Response = $obj['responseList'][0];

    $responseObj = [
      'specification'         => 'multipart-json-rpc',  // TODO
      'specificationVersion'  => '0.1.0',               // TODO
      'version'               => '1.0.0',               // TODO
      'language'              => 'en',                  // TODO

      'response'              => [
        'requestId' => null,
        'error'     => [ 'code' => $Response->getError() ],
        'data'      => $Response->getData(),
      ],
    ];

    $returnJson = $this->Reform->item($responseObj, ['type' => 'objToJson']);
    if($returnJson === NULL){
      $responseObj = [
        'specification'         => 'multipart-json-rpc',  // TODO
        'specificationVersion'  => '0.1.0',               // TODO
        'version'               => '1.0.0',               // TODO
        'language'              => 'en',                  // TODO

        'response'              => [
          'requestId' => null,
          'error'     => [ 'code' => 'ERROR_CONVERT_RESPONSE_TO_JSON' ],
          'data'      => [],
        ],
      ];
      $returnJson = $this->Reform->item($responseObj, ['type' => 'objToJson']);
    }
    return $returnJson;
  }
}