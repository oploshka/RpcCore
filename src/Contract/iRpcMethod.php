<?php

namespace Oploshka\RpcContract;

interface iRpcMethod {

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
  
  
  public function getRpcMethodDataObj();
  public function setRpcMethodDataObj($data);
  public function getRpcMethodResponseObj() :iRpcResponse;
}
