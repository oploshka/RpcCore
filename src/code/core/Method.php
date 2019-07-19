<?php

namespace Oploshka\Rpc;


abstract class Method implements \Oploshka\RpcInterface\Method {

  protected $Response;
  protected $Data;
  // TODO // protected $Logger;

  public function __construct($obj){
    $this->Response = $obj['response'];
    $this->Data     = $obj['data'];
    // TODO // $this->Logger   = $obj['logger'];
  }

}
