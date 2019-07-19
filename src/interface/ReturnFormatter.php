<?php

namespace Oploshka\RpcInterface;

interface ReturnFormatter {

  /**
   *
   * @param $obj
   *  - string $methodName
   *  - array $methodData
   *  - Response $Response
   *  - ErrorStorage $ErrorStore
   *
   * @return
   **/
  public function format($obj);
  
}
