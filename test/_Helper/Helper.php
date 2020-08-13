<?php

namespace Oploshka\RpcTestHelper;

class Helper {

  public static function getRpc(){
    $Rpc = new \Oploshka\Rpc\Rpc();
    $Rpc->applyPhpSettings();
    return $Rpc;
  }
  
}
