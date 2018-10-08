<?php

namespace Rpc\Utils;

interface MethodInterface {
  
  /**
   * Get RPC method description
   * 
   * @return string
   **/
  public function description();
  
  /**
   * Get validation scheme
   * 
   * @return array Validation scheme
   **/
  public function validate();
  
  /**
   * Main RPC method 
   * 
   * not return! run $_RESPONSE->error('ERROR_NOT')
   * 
   * @param Response $_RESPONSE
   * @param array $_DATA
   */
  public function run(&$_RESPONSE, $_DATA = array() );

}
