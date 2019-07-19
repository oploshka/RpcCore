<?php

namespace Oploshka\RpcHelperTest\ReturnFormatter;

class ReturnFormatter implements \Oploshka\RpcInterface\ReturnFormatter{
  public function format($obj) {
    return $obj;
  }
}