<?php

namespace Oploshka\Rpc\Plugin\RpcResponseStructure;

use Oploshka\RpcContract\iRpcRequest;
use Oploshka\RpcContract\iRpcResponse;

/**
 * {
 *   "specification": "multipart-json-rpc",
 *   "specificationVersion": "0.1.0",
 *   "version": "1.0.0",
 *   "language": "en",
 *   "response": {
 *     "requestId": "9423234",
 *     "error": {
 *       "code": "ERROR_NO_METHOD_INFO",
 *       "message": "",
 *       "data": []
 *     },
 *     "data": []
 *   }
 * }
 *
 */
class MultipartJsonRpcResponse {
  
  public function decode($arr) {
    if(
      !is_array($arr)
      || !isset( $arr['request'] )
      || !is_array($arr['request'])
      || !isset($arr['request']['name']) || !is_string($arr['request']['name'])
      || !isset($arr['request']['data']) || !is_array($arr['request']['data'])
    ){
      throw new \Oploshka\RpcException\ReformException('ERROR_RESPONSE_STRUCTURE_DECODE');
    }
    
    return new \Oploshka\Rpc\RpcResponse();
  }
  
  /**
   * @param  \Oploshka\Rpc\RpcResponseOld $RpcResponse
   * @return array
   */
  public function encode(iRpcResponse $rpcResponse, ?iRpcRequest $rpcRequest = null){

    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1.0',
      'version'               => $rpcRequest ? $rpcRequest->getVersion()    : '1.0',
      'language'              => $rpcRequest ? $rpcRequest->getLanguage()   : 'en',
  
      'response'              => [
        'requestId' => $rpcRequest ? $rpcRequest->getRequestId() : null,
        'error'     => [
          "code"      => $rpcResponse->getErrorCode(),
          "message"   => $rpcResponse->getErrorMessage(),
          "data"      => $rpcResponse->getErrorData()
        ],
        'data'      => $rpcResponse->getData(),
      ],
    ];
  }
  
}
