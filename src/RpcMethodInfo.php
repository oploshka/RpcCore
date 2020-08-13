<?php

namespace Oploshka\Rpc;

use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class RpcMethodInfo {
  
  private $requestId  = null;
  private $methodName = '';
  private $data       = [];
  private $language   = 'en';
  private $version    = '0.1.0';
  
  public function __construct($arr) {
  
    if(!isset($arr['methodName']) || !is_string($arr['methodName']) || $arr['methodName'] == ''){
      // TODO fix
      throw new Exception();
    }
    
    $arr['requestId']  && $this->requestId  = $arr['requestId'];
    // TODO: require
    $arr['methodName'] && $this->methodName = $arr['methodName'];
    //
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
