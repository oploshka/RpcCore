<?php

namespace Oploshka\RpcInterface;

interface DataFormatter {

  /**
   * start load data and return 'ERROR_NOT' for success load or error string code
   *
   * @param string $methodName
   * @param array $methodData
   *
   * @return string
   **/
  public function prepare($loadData, &$methodList, &$requestType);
  
}

