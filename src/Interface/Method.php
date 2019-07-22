<?php

namespace Oploshka\RpcInterface;

interface Method {

  // protected $Response;
  // protected $Data;
  // protected $Logger;

  public function __construct($obj);

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
   * not return! run $this->Response->error('ERROR_NOT')
   *
   */
  public function run();
  
  /**
   * Get validation return scheme
   *
   * @return array Validation scheme
   **/
  public function return();
  
}
