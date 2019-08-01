<?php

namespace Oploshka\Rpc;


abstract class Method implements \Oploshka\RpcInterface\Method {

  protected $Response;
  protected $Data;
  protected $Logger;

  public function __construct($obj){
    $this->Response = $obj['response'];
    $this->Data     = $obj['data'];
    $this->Logger   = $obj['logger'];
  }

}
