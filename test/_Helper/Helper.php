<?php

namespace Oploshka\RpcTestHelper;

class Helper {

  public static function getRpc(){
    $Rpc = new \Oploshka\Rpc\Rpc();
    $Rpc->applyPhpSettings();
    //
    $RpcMethodStorage = $Rpc->getRpcMethodStorage();
    
    // add error method
    $RpcMethodStorage->add('InterfaceNotRealization', '\\Oploshka\\RpcTestHelper\\Method\\Error\\InterfaceNotRealization'     , 'Error');
    $RpcMethodStorage->add('RunUnknownFunction'     , '\\Oploshka\\RpcTestHelper\\Method\\Error\\RunUnknownFunction'          , 'Error');
    
    // add method return data
    $RpcMethodStorage->add('BaseReturnData'         , '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\BaseReturnData'         , 'ReturnData');
    $RpcMethodStorage->add('ReplaceReturnData'      , '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\ReplaceReturnData'      , 'ReturnData');
    $RpcMethodStorage->add('ReturnRequestSchemaData', '\\Oploshka\\RpcTestHelper\\Method\\ReturnData\\ReturnRequestSchemaData', 'ReturnData');
    
    return $Rpc;
  }
  
}
