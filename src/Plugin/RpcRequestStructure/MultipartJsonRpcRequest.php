<?php

namespace Oploshka\Rpc\Plugin\RpcRequestStructure;


use Oploshka\Rpc\RpcRequest;
use Oploshka\RpcException\RpcException;

/**
 * Class MultipartJsonRpcRequest
 * @package Oploshka\Rpc\Plugin\RpcStructureRequest
 *
 *  {
 *    "specification": "multipart-json-rpc",
 *    "specificationVersion" : "0.1.0",
 *    "version": "1",
 *    "language": "en",
 *    "request" : {
 *      "id"   : "9423234",
 *      "name" : "MethodTest1",
 *      "data" : { "userId" : 1 }
 *    }
 *  }
 */
class MultipartJsonRpcRequest {
  
  public function decode($arr) :RpcRequest {
  
    if( !is_array($arr) ){
      throw new RpcException('ERROR_REQUEST_STRUCTURE_DECODE', ['arr' => $arr], 'structure is not array');
    }
    if( !isset($arr['request']) ){
      throw new RpcException('ERROR_REQUEST_STRUCTURE_DECODE', [], 'not require "request" params');
    }
    if( !is_array($arr['request']) ){
      throw new RpcException('ERROR_REQUEST_STRUCTURE_DECODE', [], '"request" params is not array');
    }
    if( !isset($arr['request']['name']) || !is_string($arr['request']['name']) ){
      throw new RpcException('ERROR_REQUEST_STRUCTURE_DECODE', [], '"request.name" params error');
    }
    if( !isset($arr['request']['data']) || !is_array($arr['request']['data']) ){
      throw new RpcException('ERROR_REQUEST_STRUCTURE_DECODE', [], '"request.data" params error');
    }
    
    return new RpcRequest([
      'requestId'   => $arr['request']['id'] ?? null,
      'methodName'  => $arr['request']['name'],
      'data'        => $arr['request']['data'],
      // TODO
      // 'language'    => $arr['request']['data'],
      // 'version'     => $arr['request']['data'],
    ]);
  
  }
  
  /**
   * @param \Oploshka\Rpc\RpcRequest $RpcMethodInfo
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
