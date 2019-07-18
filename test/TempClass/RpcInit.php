<?php

namespace Oploshka\RpcTest\TempClass;

class RpcInit {


  public static function getRpcReform(){
    return new \Oploshka\Reform\Reform();
  }
  public static function getDataLoader(){
    return new \Oploshka\RpcTest\TempClass\DataLoaderSuccess();
  }
  public static function getReturnFormatter(){
    return new \Oploshka\RpcTest\TempClass\ReturnFormatterSuccess();;
  }
  public static function getRpcMethodStorage(){
    $MethodStorage  = new \Oploshka\Rpc\MethodStorage();
    $MethodStorage->add('methodTest1', 'Oploshka\\RpcTest\\TempClass\\MethodTest1');
    $MethodStorage->add('methodTest2', 'Oploshka\\RpcTest\\TempClass\\MethodTest2');
    return $MethodStorage;
  }


  public static function getRpc(){
    $MethodStorage    = self::getRpcMethodStorage();
    $Reform           = self::getRpcReform();
    $DataLoader       = self::getDataLoader();
    $ReturnFormatter  = self::getReturnFormatter();
    $ResponseClass = new \Oploshka\Rpc\Response();

    $rpcInitData = [
      'methodStorage'   => $MethodStorage    ,
      'reform'          => $Reform           ,
      'dataLoader'      => $DataLoader       ,
      'dataFormatter'   => false, // $DataFormatter    ,
      'returnFormatter' => $ReturnFormatter  ,
      'responseClass'   => $ResponseClass    ,
    ];

    $Rpc = new \Oploshka\Rpc\Core($rpcInitData);
    return $Rpc;
  }
  
}