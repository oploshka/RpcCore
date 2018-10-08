<?php
/**
 * Created by PhpStorm.
 * User: ANDREV
 * Date: 18.04.2018
 * Time: 10:18
 */

namespace Rpc\Utils;


class MethodStorage {
  
  private static $methods = array();
  
  /**
   * 
   * @param string $methodName
   * @param string $methodGroup
   * @param string $methodClass
   * @throws \Exception
   */
  public static function add($methodName, $methodGroup, $methodClass){
    
    // Название метода должно быть строкой
    if( !is_string($methodName) ){
      throw new \Exception('RPCMethodStorage: Method name no string');
    }
    if( !is_string($methodGroup) ){
      throw new \Exception('RPCMethodStorage: Method group no string');
    }
    if( !is_string($methodClass) ){
      throw new \Exception('RPCMethodStorage: Method class no string');
    }
    
    // Запрет переопределения существующего метода
    if( isset(self::$methods[$methodName]) ){
      throw new \Exception('RPCMethodStorage: Add dublicate method >>' . $methodName . '<<');
    }
    
    // если все хорошо то добавляем
    self::$methods[$methodName] = [
      'group' => $methodGroup,
      'class' => $methodClass,
    ];
  }
  
  /**
   * @return array || false
   */
  public static function getMethodInfo($methodName) {
    if( !isset(self::$methods[$methodName]) ){
      return false;
    }
    return self::$methods[$methodName];
  }
}
