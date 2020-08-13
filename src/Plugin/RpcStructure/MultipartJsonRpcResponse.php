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
class MultipartJsonRpcResponse implements \Oploshka\RpcInterface\RpcStructure {
  
  /**
   * @param array $arr
   * @return \Oploshka\Rpc\RpcMethodResponse
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
      throw new \Oploshka\RpcException\RpcException('ERROR_RESPONSE_STRUCTURE_DECODE');
    }
    
    return new \Oploshka\Rpc\RpcMethodResponse([
      'requestId'   => $arr['request']['id'] ?? null,
      'methodName'  => $arr['request']['name'],
      'data'        => $arr['request']['data'],
      // TODO
      // 'language'    => $arr['request']['data'],
      // 'version'     => $arr['request']['data'],
    ]);
  }
  
  /**
   * @param  \Oploshka\Rpc\RpcMethodResponse $RpcMethodResponseObj
   * @return array
   */
  public function encode($RpcMethodResponseObj){

    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1.0',
      'version'               => '1.0.0',               // TODO
      'language'              => 'en',                  // TODO
  
      'response'              => [
        'requestId' => $RpcMethodResponseObj->getResponseId(), // TODO: fix
        'error'     => [
          "code"      => $RpcMethodResponseObj->getErrorCode(),
          "message"   => $RpcMethodResponseObj->getErrorMessage(),
          "data"      => $RpcMethodResponseObj->getErrorData()
        ],
        'data'      => $RpcMethodResponseObj->getData(),
      ],
    ];
  }
  
}
