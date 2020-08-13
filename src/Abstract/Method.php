<?php

namespace Oploshka\RpcAbstract;


abstract class Method implements \Oploshka\RpcInterface\Method {

  protected $Response;
  protected $Data;
  protected $Logger;

  public function __construct($obj){
    $this->Response = $obj['response'];
    $this->Data     = $obj['data'];
    $this->Logger   = $obj['logger'];
  }
  
  public static function description() { return ''; }
  
  // public static function requestSchema() { return []; }
  // public static function responseSchema() { return []; }
  
  abstract public function run();

}
