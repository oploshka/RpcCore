<?php

namespace Oploshka\RpcTest\TempClass;

class ReturnFormatter implements \Oploshka\RpcInterface\ReturnFormatter{
  public function format($responseList) {
    return $responseList;
  }
}