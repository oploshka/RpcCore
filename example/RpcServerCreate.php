<?php

namespace RpcExample;

use Oploshka\Rpc\Method\RpcMethodStorage;

class RpcServerCreate {
  
  public static function getRpcMethodStorage(){
    $rpcMethodStorage = new RpcMethodStorage();
    $rpcMethodStorage->add('MethodBase', '\\Oploshka\\RpcTestHelper\\MethodBase\\BaseExample', 'Base');
    // // add error method
    // $RpcMethodStorage->add('InterfaceNotRealization', '\\Oploshka\\RpcTestHelper\\Method\\Error\\InterfaceNotRealization'     , 'Error');
    // $RpcMethodStorage->add('RunUnknownFunction'     , '\\Oploshka\\RpcTestHelper\\Method\\Error\\RunUnknownFunction'          , 'Error');
    //
    // // add method return data
    // $RpcMethodStorage->add('BaseReturnData'         , '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\BaseMethod', 'ReturnData');
    // $RpcMethodStorage->add('ReplaceReturnData'      , '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\ReplaceReturnData'      , 'ReturnData');
    // $RpcMethodStorage->add('ReturnRequestSchemaData', '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\ReturnRequestSchemaData', 'ReturnData');
    return $rpcMethodStorage;
  }
  
  public static function getRpc(){
    $rpcMethodStorage = self::getRpcMethodStorage();
    $rpc = new \Oploshka\Rpc\Rpc($rpcMethodStorage);
    // $Rpc->applyPhpSettings();
    
    return $rpc;
  }

}

