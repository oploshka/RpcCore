<?php

namespace Oploshka\RpcStructure;

/*
{
  "specification": "multipart-json-rpc",
  "specificationVersion" : "0.1.0",

  "version": "1",
  "language": "en",

  "request" : {
    "id"   : "9423234",
    "name" : "MethodTest1",
    "data" : { "userId" : 1 }
  }
}
*/
class MultipartJsonRpcRequest implements \Oploshka\RpcInterface\RpcStructure {
  
  public function decode($arr) {
  
    if(
      !is_array($arr)
      || !isset( $arr['request'] )
      || !is_array($arr['request'])
      || !isset($arr['request']['name']) || !is_string($arr['request']['name'])
      || !isset($arr['request']['data']) || !is_array($arr['request']['data'])
    ){
      throw new \Oploshka\RpcException\RpcException('ERROR_REQUEST_STRUCTURE_DECODE');
    }
    
    return new \Oploshka\Rpc\RpcMethodRequest([
      'requestId'   => $arr['request']['id'] ?? null,
      'methodName'  => $arr['request']['name'],
      'data'        => $arr['request']['data'],
      // TODO
      // 'language'    => $arr['request']['data'],
      // 'version'     => $arr['request']['data'],
    ]);
  
  }
  
  /**
   * @param \Oploshka\Rpc\RpcMethodRequest $RpcMethodInfo
   **/
  public function encode($RpcMethodInfo){

    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1.0',
      'version'               => $RpcMethodInfo->getVersion(),
      'language'              => $RpcMethodInfo->getLanguage(),
  
      'request'               => [
        'id'        => $RpcMethodInfo->getRequestId(),
        'name'      => $RpcMethodInfo->getMethodName(),
        'data'      => $RpcMethodInfo->getData(),
      ],
    ];
  }
  
}
