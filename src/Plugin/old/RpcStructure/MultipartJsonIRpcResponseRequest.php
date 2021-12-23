<?php

namespace Oploshka\RpcStructure;

/*
 *
{
  "specification": "multipart-json-rpc",
  "specificationVersion": "0.1.0",
  "version": "1.0.0",
  "language": "en",
  "response": {
    "requestId": "9423234",
    "error": {
      "code": "ERROR_NO_METHOD_INFO",
      "message": "",
      "data": []
    },
    "data": []
  }
}
 **/
class MultipartJsonIRpcResponseRequest implements \Oploshka\RpcContract\iRpcStructureRequest {
  
  /**
   * @param array $arr
   * @return \Oploshka\Rpc\RpcResponseOld
   * @throws \Exception
   */
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
    
    return new \Oploshka\Rpc\RpcResponseOld([
      'requestId'   => $arr['request']['id'] ?? null,
      'methodName'  => $arr['request']['name'],
      'data'        => $arr['request']['data'],
      // TODO
      // 'language'    => $arr['request']['data'],
      // 'version'     => $arr['request']['data'],
    ]);
  }
  
  /**
   * @param  \Oploshka\Rpc\RpcResponseOld $RpcResponse
   * @return array
   */
  public function encode($RpcResponse){

    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1.0',
      'version'               => $RpcResponse->getRpcRequest()->getVersion(),
      'language'              => $RpcResponse->getRpcRequest()->getLanguage(),
  
      'response'              => [
        'requestId' => $RpcResponse->getRpcRequest()->getRequestId(),
        'error'     => [
          "code"      => $RpcResponse->getErrorCode(),
          "message"   => $RpcResponse->getErrorMessage(),
          "data"      => $RpcResponse->getErrorData()
        ],
        'data'      => $RpcResponse->getData(),
      ],
    ];
  }
  
}
