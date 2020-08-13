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
  
  // расшифровать
  public function decode($loadData) {
  
    // TODO: delete
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
      throw new Exception(); // TODO: 'ERROR_NOT_CORRECT_REQUEST';
    }
    if( !isset($loadData['request']['id'])    ){
      $loadData['request']['id'] = null;
    }
    if( !isset($loadData['request']['name'])  ){
      throw new Exception(); // TODO: 'ERROR_NO_METHOD_NAME';
    }
    if( !isset($loadData['request']['data']) || !is_array($loadData['request']['data'])  ){
      throw new Exception(); // TODO: 'ERROR_NOT_CORRECT_REQUEST_DATA';
    }
  
    // TODO: delete
    $requestInfo['request']['id']   = $loadData['request']['id'];
    $requestInfo['request']['name'] = $loadData['request']['name'];
    $requestInfo['request']['data'] = $loadData['request']['data'];
  
    return new \Oploshka\Rpc\RpcMethodInfo([
      'requestId'   => $requestInfo['request']['id'],
      'methodName'  => $requestInfo['request']['name'],
      'data'        => $requestInfo['request']['data'],
      // TODO
      // 'language'    => $requestInfo['request']['data'],
      // 'version'     => $requestInfo['request']['data'],
    ]);
  }
  
  // зашифровать
  public function encode($RpcMethodResponse, $RpcMethodInfoObj){
    // TODO: fix
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
  
}
