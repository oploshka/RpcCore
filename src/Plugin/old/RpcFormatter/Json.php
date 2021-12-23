<?php

namespace Oploshka\RpcFormatter;

use Oploshka\RpcContract\iRpcFormatter;

class Json implements iRpcFormatter {
  
  public function decode($str){
    $Reform = new \Oploshka\Reform\Reform([]);
    $data = $Reform->item($str, ['type' => 'json']);
    if ($data === NULL){
      throw new \Oploshka\RpcException\ReformException('ERROR_REQUEST_FORMAT_DECODE');
    }
    
    return $data;
  }
  
  
  public function encode($returnObj){
    $Reform = new \Oploshka\Reform\Reform([]);
    $returnJson = $Reform->item($returnObj, ['type' => 'objToJson']);
    if($returnJson === NULL){
      throw new \Oploshka\RpcException\ReformException('ERROR_RESPONSE_FORMAT_ENCODE');
    }
    return $returnJson;
  }
  
  public function print($returnObj){
    // TODO: add header and test
    echo $this->encode($returnObj);
  }
  
  
}
