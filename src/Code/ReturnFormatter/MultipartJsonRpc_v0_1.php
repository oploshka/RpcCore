<?php

namespace Oploshka\RpcReturnFormatter;

class MultipartJsonRpc_v0_1 implements \Oploshka\RpcInterface\ReturnFormatter{
  
  private $Reform;
  
  function  __construct(){
    $this->Reform = new \Oploshka\Reform\Reform([]);
  }

  public static function getDefaultRequest(){
    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1.0',
      'version'               => '1.0.0',               // TODO
      'language'              => 'en',                  // TODO

      'response'              => [
        'requestId' => null,
        'error'     => [ 'code' => 'ERROR_DEFAULT_REQUEST' ],
        'data'      => [],
      ],
    ];
  }

  public function formatSingle($obj) {

    $Response = $obj['responseList'][0];
    $loadData = $obj['loadData'] ?? null;

    $responseObj = self::getDefaultRequest();
    $responseObj['response']['requestId'] = isset($loadData['request']['id']) ? $loadData['request']['id'] : null;
    $responseObj['response']['error']['code'] = $Response->getError();
    $responseObj['response']['data'] = $Response->getData();

    return $responseObj;
  }

  public function formatMultiple($obj) {

    $ResponseList = $obj['responseList'];
    $loadData = $obj['loadData'] ?? null;

    $result  = [];
    $len = -1;
    foreach ($ResponseList as $Response){
      $len++;

      $responseObj = self::getDefaultRequest();
      if(isset($loadData['request']['data']['multiple'][$len]['id'])){
        $responseObj['response']['requestId'] = $loadData['request']['data']['multiple'][$len]['id'];
      }
      $responseObj['response']['error']['code'] = $Response->getError();
      $responseObj['response']['data'] = $Response->getData();

      $result[] = $responseObj['response'];
    }

    $responseObj = self::getDefaultRequest();
    $responseObj['response']['requestId'] = isset($loadData['request']['id']) ? $loadData['request']['id'] : null;
    $responseObj['response']['error']['code'] = 'ERROR_NO';
    $responseObj['response']['data']['multiple'] = $result;

    return $responseObj;
  }

  public function format($obj) {
    /*[
      'requestType'   => $requestType,
      'responseList' => [ $Response ],
      // 'loadData'     => [],
      // 'methodList'   => [],
    ]*/


    if($obj['requestType'] === 'multiple'){
      $responseObj = $this->formatMultiple($obj);
    } else {
      $responseObj = $this->formatSingle($obj);
    }

    $returnJson = $this->Reform->item($responseObj, ['type' => 'objToJson']);
    if($returnJson === NULL){
      $responseObj = [
        'specification'         => 'multipart-json-rpc',
        'specificationVersion'  => '0.1.0',
        'version'               => '1.0.0',
        'language'              => 'en',

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