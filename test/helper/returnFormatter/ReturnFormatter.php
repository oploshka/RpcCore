<?php

namespace Oploshka\RpcReturnFormatterTest;

class ReturnFormatter implements \Oploshka\RpcInterface\ReturnFormatter{
  public function format($obj) {
    return $obj;
  }
}