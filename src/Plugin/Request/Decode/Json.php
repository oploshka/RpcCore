<?php

namespace Oploshka\RpcRequestDecode;

class Json {
  
  public function decode(&$loadData){
    $Reform = new \Oploshka\Reform\Reform([]);
    $data = $this->Reform->item($_POST[$this->filed], ['type' => 'json']);
    if ($data === NULL){
      // TODO: throw new Exception();
    }
    
    return $data;
  }
  
}
