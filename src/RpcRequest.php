<?php

namespace Oploshka\Rpc;

class RpcRequest {
  
  private $requestId  = null;
  private string $methodName = '';
  private array  $data       = [];
  private string $language   = 'en';
  private string $version    = '0.1.0';
  
  public function __construct($arr) {
  
    if(!isset($arr['methodName']) || !is_string($arr['methodName']) || $arr['methodName'] == ''){
      // TODO fix
      throw new \Exception();
    }
    
    isset($arr['requestId'])  && $this->requestId  = $arr['requestId'];
    // TODO: require
    isset($arr['methodName']) && $this->methodName = $arr['methodName'];
    //
    isset($arr['data']      ) && $this->data       = $arr['data'];
    isset($arr['language']  ) && $this->language   = $arr['language'];
    isset($arr['version']   ) && $this->version    = $arr['version'];
  }
  
  public function getRequestId() {
    return $this->requestId;
  }
  public function getMethodName() :string {
    return $this->methodName;
  }
  public function getData() :array {
    return $this->data;
  }
  public function getLanguage() :string {
    return $this->language;
  }
  public function getVersion() :string {
    return $this->version;
  }

}
