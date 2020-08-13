<?php

namespace Oploshka\RpcLoaderStructure;

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
        'error'     => [ 'code' => 'ERROR_DEFAULT_REQUEST', 'message' => '', 'data' => [] ],
        'data'      => [],
      ],
    ];
  }
  
  public function formatSingle($obj) {
    
    $Response = $obj['responseList'][0];
    $loadData = $obj['loadData'] ?? null;
    $Logger   = $obj['logger'];
    
    $responseObj = self::getDefaultRequest();
    $responseObj['response']['requestId'] = isset($loadData['request']['id']) ? $loadData['request']['id'] : null;
    $responseObj['response']['error'] = $Response->getError();
    $responseObj['response']['data']  = $Response->getData();
    
    $responseObj['debug'] = $Logger->getLog();
    return $responseObj;
  }
  
  public function formatMultiple($obj) {
    
    $ResponseList = $obj['responseList'];
    $loadData = $obj['loadData'] ?? null;
    $Logger   = $obj['logger'];
    
    $result  = [];
    $len = -1;
    foreach ($ResponseList as $Response){
      $len++;
      
      $responseObj = self::getDefaultRequest();
      if(isset($loadData['request']['data']['multiple'][$len]['id'])){
        $responseObj['response']['requestId'] = $loadData['request']['data']['multiple'][$len]['id'];
      }
      $responseObj['response']['error'] = $Response->getError();
      $responseObj['response']['data'] = $Response->getData();
      
      $result[] = $responseObj['response'];
    }
    
    $responseObj = self::getDefaultRequest();
    $responseObj['response']['requestId'] = isset($loadData['request']['id']) ? $loadData['request']['id'] : null;
    $responseObj['response']['error']['code'] = 'ERROR_NO';
    $responseObj['response']['data']['multiple'] = $result;
    $responseObj['debug'] = $Logger->getLog();
    
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
