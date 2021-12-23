<?php

namespace Oploshka\RpcTestHelper;

use Oploshka\Rpc\Method\RpcMethodStorage;

class Helper {

  public static function getRpc(){
    $rpcMethodStorage = new RpcMethodStorage();
    $rpcMethodStorage->add('MethodBase', '\\Oploshka\\RpcTestHelper\\MethodBase\\MethodBase', 'Base');
    // // add error method
    // $RpcMethodStorage->add('InterfaceNotRealization', '\\Oploshka\\RpcTestHelper\\Method\\Error\\InterfaceNotRealization'     , 'Error');
    // $RpcMethodStorage->add('RunUnknownFunction'     , '\\Oploshka\\RpcTestHelper\\Method\\Error\\RunUnknownFunction'          , 'Error');
    //
    // // add method return data
    // $RpcMethodStorage->add('BaseReturnData'         , '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\BaseMethod', 'ReturnData');
    // $RpcMethodStorage->add('ReplaceReturnData'      , '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\ReplaceReturnData'      , 'ReturnData');
    // $RpcMethodStorage->add('ReturnRequestSchemaData', '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\ReturnRequestSchemaData', 'ReturnData');
    
    
    $rpc = new \Oploshka\Rpc\Rpc($rpcMethodStorage);
    // $Rpc->applyPhpSettings();
    //
  
    return $rpc;
  }
  
}
