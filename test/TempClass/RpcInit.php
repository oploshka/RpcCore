<?php

namespace Oploshka\RpcTest\TempClass;

class RpcInit {

  public static function getRpcTestData(){
    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1',
      'language'              => 'ru',
      'method'                => 'MethodTest1',
      'params'                => [
        'string'  => 'string',
        'int'     => 123456,
        'float'   => 1.2345,
        'array'   => [
          'array->string'  => 'array->string',
          'array->int'     => 654321,
          'array->float'   => 6.5432,
        ],
      ],
    ];
  }

  public static function getRpcReform(){
    return new \Oploshka\Reform\Reform();
  }
  public static function getDataLoader(){
    return new \Oploshka\RpcTest\TempClass\DataLoader();
  }
  public static function getDataFormatter(){
    return new \Oploshka\RpcTest\TempClass\DataFormatter();
  }
  public static function getReturnFormatter(){
    return new \Oploshka\RpcTest\TempClass\ReturnFormatter();
  }
  public static function getRpcMethodStorage(){
    $MethodStorage  = new \Oploshka\Rpc\MethodStorage();
    $MethodStorage->add('methodTest1', 'Oploshka\\RpcTest\\TempClass\\MethodTest1');
    $MethodStorage->add('methodTest2', 'Oploshka\\RpcTest\\TempClass\\MethodTest2');
    return $MethodStorage;
  }
  public static function getResponseClass(){
    return  new \Oploshka\Rpc\Response();
  }

  public static function getRpc(){

    $rpcInitData = [
      'methodStorage'   => self::getRpcMethodStorage()  ,
      'reform'          => self::getRpcReform()         ,
      'dataLoader'      => self::getDataLoader()        ,
      'dataFormatter'   => self::getDataFormatter()     ,
      'returnFormatter' => self::getReturnFormatter()   ,
      'responseClass'   => self::getResponseClass()     ,
    ];

    $Rpc = new \Oploshka\Rpc\Core($rpcInitData);
    $Rpc->applyPhpSettings();
    return $Rpc;
  }
  
}