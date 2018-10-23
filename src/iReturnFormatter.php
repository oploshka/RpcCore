<?php

namespace Oploshka\Rpc;

// TODO: need optimization
interface iReturnFormatter {
  
  /**
   * start load data and return 'ERROR_NOT' for success load or error string code
   *
   * @param string $methodName
   * @param array $methodData
   *
   * @return string
   **/
  public function prepare($loadData, &$methodName, &$methodData);
  
  /**
   *
   * @param string $methodName
   * @param array $methodData
   * @param Response $Response
   * @param iErrorStorage $ErrorStore
   *
   * @return
   **/
  public function format($methodName, $methodData, $Response, $ErrorStore);
  
}
