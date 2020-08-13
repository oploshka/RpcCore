<?php

namespace Oploshka\RpcFormatter;

class Json {
  
  public function decode($str){
    $Reform = new \Oploshka\Reform\Reform([]);
    $data = $Reform->item($str, ['type' => 'json']);
    if ($data === NULL){
      throw new \Exception(); // TODO: add exception name
    }
    
    return $data;
  }
  
  
  public function encode($returnObj){
    $Reform = new \Oploshka\Reform\Reform([]);
    $returnJson = $Reform->item($returnObj, ['type' => 'objToJson']);
    if($returnJson === NULL){
      // TODO: fix
      // $returnObj = [
      //   "jsonrpc" => "2.0",
      //   "error"   => 'ERROR_CONVERT_RESPONSE_TO_JSON', // todo: {"code": -32700, "message": "Parse error"},
      //   'result'  => [],
      //   "id"      => null
      // ];
      // $returnJson = $this->Reform->item($returnObj, ['type' => 'objToJson']);
    }
    return $returnJson;
  }
  
  public function print($returnObj){
    // TODO: add header and test
    echo $this->encode($returnObj);
  }
  
  
}
