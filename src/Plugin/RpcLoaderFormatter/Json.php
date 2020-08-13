<?php

namespace Oploshka\RpcLoaderFormatter;

class Json {
  
  public function decode(&$loadData){
    $Reform = new \Oploshka\Reform\Reform([]);
    $data = $Reform->item($_POST[$this->filed], ['type' => 'json']);
    if ($data === NULL){
      // TODO: throw new Exception();
    }
    
    return $data;
  }
  
  
  public function encode($returnObj){
    $Reform = new \Oploshka\Reform\Reform([]);
    $returnJson = $Reform->item($returnObj, ['type' => 'objToJson']);
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
