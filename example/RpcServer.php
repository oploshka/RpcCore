<?php

namespace Oploshka\RpcExample;

use Oploshka\Rpc\Method\RpcMethodStorage;
use Oploshka\RpcExample\Enum\MethodGroup;
use Oploshka\RpcExample\Enum\MethodName;

class RpcServer {
  
  public static function getRpcMethodStorage(): RpcMethodStorage {
    $rpcMethodStorage = new RpcMethodStorage();
    $rpcMethodStorage->add(
        MethodName::SIMPLE__FAKE_AUTH,
        '\\Oploshka\\RpcExample\\Method\\Simple\\FakeAuth',
        MethodGroup::SIMPLE
    );
    $rpcMethodStorage->add(
        MethodName::SIMPLE__RETURN_SIMPLE_DATA,
        '\\Oploshka\\RpcExample\\Method\\Simple\\ReturnSimpleData',
        MethodGroup::SIMPLE
    );
    $rpcMethodStorage->add(
        MethodName::SIMPLE__VALIDATE_BASIC_DATE_TYPE,
        '\\Oploshka\\RpcExample\\Method\\Simple\\ValidateBasicDateType',
        MethodGroup::SIMPLE
    );
    // TODO use ::class
    // $rpcMethodStorage->add(MethodName::BASE_EXAMPLE, \Oploshka\RpcExample\Method\Base\BaseExample::class, MethodGroup::BASE);
    return $rpcMethodStorage;
  }
  
  public static function getRpc(){
    $rpcMethodStorage   = static::getRpcMethodStorage();
    $rpcRequestLoad     = new \Oploshka\Rpc\Plugin\RpcRequestLoad\MultipartJsonRpc();
    $rpcResponseUnload  = new \Oploshka\Rpc\Plugin\RpcResponseUnload\MultipartJsonRpc();
    $rpc = new \Oploshka\Rpc\Rpc($rpcMethodStorage, $rpcRequestLoad, $rpcResponseUnload);
    // $Rpc->applyPhpSettings();
    
    return $rpc;
  }
  
  
  public static function run(){
    $rpc = self::getRpc();
    $rpc->runRpc();
  }

}

