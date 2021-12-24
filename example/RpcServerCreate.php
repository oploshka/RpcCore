<?php

namespace Oploshka\RpcExample;

use Oploshka\Rpc\Method\RpcMethodStorage;
use Oploshka\RpcExample\Enum\MethodGroup;
use Oploshka\RpcExample\Enum\MethodName;

class RpcServerCreate {
  
  public static function getRpcMethodStorage(){
    $rpcMethodStorage = new RpcMethodStorage();
    $rpcMethodStorage->add(MethodName::BASE_EXAMPLE, '\\Oploshka\\RpcExample\\Method\\Base\\BaseExample', MethodGroup::BASE);
    // TODO use ::class
    // $rpcMethodStorage->add(MethodName::BASE_EXAMPLE, \Oploshka\RpcExample\Method\Base\BaseExample::class, MethodGroup::BASE);
    return $rpcMethodStorage;
  }
  
  public static function getRpc(){
    $rpcMethodStorage = self::getRpcMethodStorage();
    $rpc = new \Oploshka\Rpc\Rpc($rpcMethodStorage);
    // $Rpc->applyPhpSettings();
    
    return $rpc;
  }

}

