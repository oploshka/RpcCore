<?php

namespace Oploshka\RpcExample;

use Oploshka\Rpc\Method\RpcMethodStorage;
use Oploshka\RpcExample\Enum\MethodGroup;
use Oploshka\RpcExample\Enum\MethodName;

class RpcErrorServer extends RpcServer {
  
  public static function getRpcMethodStorage(): RpcMethodStorage {
    $rpcMethodStorage = new RpcMethodStorage();
    $rpcMethodStorage->add(
        MethodName::ERROR__InterfaceNotRealization,
        '\\Oploshka\\RpcExample\\Method\\Error\\InterfaceNotRealization',
        MethodGroup::ERROR
    );
    $rpcMethodStorage->add(
        MethodName::ERROR__RunUnknownFunction,
        '\\Oploshka\\RpcExample\\Method\\Error\\RunUnknownFunction',
        MethodGroup::ERROR
    );
    return $rpcMethodStorage;
  }

}

