<?php

namespace Oploshka\Rpc\RpcLoadRequest;

use Oploshka\Rpc\Plugin\RpcLoadContent\Post_MultipartFormData_Field;
use Oploshka\Rpc\Plugin\RpcStructureRequest\MultipartJsonRpcRequest;
use Oploshka\RpcContract\iRpcLoadRequest;

class MultipartJsonRpc implements iRpcLoadRequest {
  
  private $contentLoad;
  private $requestStructureParser;
  
  public function __construct(){
    $this->contentLoad = new Post_MultipartFormData_Field('data');
    $this->requestStructureParser = new MultipartJsonRpcRequest();
  }
  
  public function load() {
    $data = $this->contentLoad->load();
    return $this->requestStructureParser->decode($data);
  }

}

/*

public function load() :iRpcRequest {
  // получим данные
  $loadStr = $this->RpcRequestLoad->load();
  // расшифруем
  $loadData = $this->RpcRequestFormatter->decode($loadStr);
  // считываем структуру
  $RpcMethodRequest = $this->RpcRequestStructure->decode($loadData);
  //
  return $RpcMethodRequest;
}
 */