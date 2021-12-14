<?php

namespace Oploshka\RpcInterface;

interface iRpcMethod {

  // protected $Response;
  // protected $Data;

  public function __construct();

  /**
   * Get RPC method description
   */
  public static function description() :string;

  
  /**
   * Main RPC method
   * not return! run $this->Response->error('ERROR_NO')
   */
  public function run();
  
}
