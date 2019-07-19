<?php

namespace Oploshka\RpcInterface;

// TODO: need optimization
interface Core {

  public function __construct($obj);

  public function startProcessingRequest();
  public function startProcessingMethod($methodName, $methodData );

}
