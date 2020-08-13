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
  public static function description();
  
  /**
   * Get validation scheme
   *
   * @return array Validation scheme
   **/
  public static function requestSchema();
  
  /**
   * Main RPC method
   *
   * not return! run $this->Response->error('ERROR_NO')
   *
   */
  public function run();
  
  /**
   * Get validation return scheme
   *
   * @return array response validation scheme
   **/
  public static function responseSchema();
  
}
