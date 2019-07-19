<?php

namespace Oploshka\RpcReturnFormatter;

class JsonRpc_v2_0 implements \Oploshka\RpcInterface\ReturnFormatter {
  
  private $Reform;
  
  function  __construct(){
    $this->Reform = new \Oploshka\Reform\Reform([]);
  }
  
  public function prepare($loadData, &$methodName, &$methodData) {
  
    if( !isset($loadData['method']) ) {
      return 'ERROR_NO_METHOD_NAME';
    }
    if( !isset($loadData['params']) ) {
      return 'ERROR_NO_METHOD_PARAMS';
    }
  
    // // todo: id, jsonrpc
    
    $methodName = $loadData['method'];
    $methodData = $loadData['params'];
    
    return 'ERROR_NOT';
    
  }
  public function format($methodName, $methodData, $Response, $ErrorStore) {
    
    $returnObj = [
      "jsonrpc" => "2.0",
      "error"   => $Response->getError(), // todo: {"code": -32700, "message": "Parse error"},
      'result'  => $Response->getData(),
      "id"      => null
    ];
    
    $log = $Response->getLog();
    if($log !== []){
      $returnObj['logs'] = $log;
    }
    
    $returnJson = $this->Reform->item($returnObj, ['type' => 'objToJson']);
    if($returnJson === NULL){
      $returnObj = [
        "jsonrpc" => "2.0",
        "error"   => 'ERROR_CONVERT_RESPONSE_TO_JSON', // todo: {"code": -32700, "message": "Parse error"},
        'result'  => [],
        "id"      => null
      ];
      $returnJson = $this->Reform->item($returnObj, ['type' => 'objToJson']);
    }
    return $returnJson;
  }
}