<?php

namespace Oploshka\RpcHelperTest;

class Helper {

  public static function getRpcTestDataParams(){
    return [
      'string'  => 'string',
      'int'     => 123456,
      'float'   => 1.2345,
      'array'   => [
        'array->string'  => 'array->string',
        'array->int'     => 654321,
        'array->float'   => 6.5432,
      ],
    ];
  }
  public static function getRpcTestData(){
    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1',
      'language'              => 'ru',
      'method'                => 'MethodTest1',
      'params'                => self::getRpcTestDataParams(),
    ];
  }
  public static function getRpcMultipleData(){
    return [
      'specification'         => 'multipart-json-rpc',
      'specificationVersion'  => '0.1',
      'language'              => 'ru',
      'method'                => 'multiple',
      'params'                => [
        [
          'method'                => 'MethodTest1',
          'params'                => self::getRpcTestDataParams(),
        ],
        [
          'method'                => 'MethodTest2',
          'params'                => self::getRpcTestDataParams(),
        ],
      ],
    ];
  }

  public static function getRpcReform(){
    return new \Oploshka\Reform\Reform();
  }
  public static function getDataLoader(){
    return new \Oploshka\RpcHelperTest\DataLoader\DataLoader();
  }
  public static function getDataFormatter(){
    return new \Oploshka\RpcHelperTest\DataFormatter\DataFormatter();
  }
  public static function getReturnFormatter(){
    return new \Oploshka\RpcHelperTest\ReturnFormatter\ReturnFormatter();
  }
  public static function getRpcMethodStorage(){
    $MethodStorage  = new \Oploshka\Rpc\MethodStorage();
    $MethodStorage->add('MethodTest1', 'Oploshka\\RpcHelperTest\\Method\\MethodTest1');
    $MethodStorage->add('MethodTest2', 'Oploshka\\RpcHelperTest\\Method\\MethodTest2');
    $MethodStorage->add('MethodTestData', 'Oploshka\\RpcHelperTest\\Method\\MethodTestData');
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