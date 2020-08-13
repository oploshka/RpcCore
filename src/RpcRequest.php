<?php

namespace Oploshka\Rpc;

class RpcRequest {
  
  private $requestId  = null;
  private $methodName = '';
  private $data       = [];
  private $language   = 'en';
  private $version    = '0.1.0';
  
  public function __construct($arr) {
    $arr['requestId']  && $this->requestId  = $arr['requestId'];
    $arr['methodName'] && $this->methodName = $arr['methodName'];
    $arr['data']       && $this->data       = $arr['data'];
    $arr['language']   && $this->language   = $arr['language'];
    $arr['version']    && $this->version    = $arr['version'];
  }
  
  public function getRequestId() {
    return $this->requestId;
  }
  public function getMethodName() {
    return $this->methodName;
  }
  public function getData() {
    return $this->data;
  }
  public function getLanguage() {
    return $this->language;
  }
  public function getVersion() {
    return $this->version;
  }

}
