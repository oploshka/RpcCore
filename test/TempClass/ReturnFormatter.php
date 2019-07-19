<?php

namespace Oploshka\RpcTest\TempClass;

class ReturnFormatter implements \Oploshka\RpcInterface\ReturnFormatter{
  public function format($obj) {
    return $obj;
  }
}