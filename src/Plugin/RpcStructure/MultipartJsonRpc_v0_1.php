<?php

namespace Oploshka\RpcStructure;

class MultipartJsonRpc_v0_1 implements \Oploshka\RpcInterface\RpcStructure {
  
  // TODO: fix
  function  __construct(){
    // request
    // $this->Logger   = $obj['logger'];
  }
  
  /*
   * $arr = [
   *  'specification'         => 'multipart-json-rpc',
   *   'specificationVersion'  => '0.1.0',
   *   'version'               => '1.0.0',
   *   'language'              => 'en',
   *   'request'               => [
   *     'id'    => null,
   *     'name'  => 'MethodName',
   *     'data'  => [],
   *   ],
   * ]
   *
   * @return \Oploshka\Rpc\RpcMethodInfo
   **/
  public function decode($arr) {
  
    if(
      !is_array($arr)
      || !isset( $arr['request'] )
      || !is_array($arr['request'])
      || !isset($arr['request']['name']) || !is_string($arr['request']['name'])
      || !isset($arr['request']['data']) || !is_array($arr['request']['data'])
    ){
      throw new \Exception(); // TODO: 'ERROR_NOT_CORRECT_REQUEST';
    }
    
    return new \Oploshka\Rpc\RpcMethodInfo([
      'requestId'   => $arr['request']['id'] ?? null,
      'methodName'  => $arr['request']['name'],
      'data'        => $arr['request']['data'],
      // TODO
      // 'language'    => $arr['request']['data'],
      // 'version'     => $arr['request']['data'],
    ]);
  
  }
  
  /*
   *
   * @return Array [
   *   'specification'         => 'multipart-json-rpc',
   *   'specificationVersion'  => '0.1.0',
   *   'version'               => '1.0.0',
   *   'language'              => 'en',
   *
   *   'response'              => [
   *     'requestId' => null,
   *     'error'     => [ 'code' => 'ERROR_DEFAULT_REQUEST', 'message' => '', 'data' => [] ],
   *     'data'      => [],
   *   ],
   * ]
   *
  */
  public function encode($RpcMethodResponseObj){

    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1.0',
      'version'               => '1.0.0',               // TODO
      'language'              => 'en',                  // TODO
  
      'response'              => [
        'requestId' => null, // TODO: fix
        'error'     => $RpcMethodResponseObj->getError(),
        'data'      => $RpcMethodResponseObj->getData(),
      ],
    ];
  }
  
}
