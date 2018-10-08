<?php

namespace Oploshka\RpcCore;

class MethodStorage {
  
  private $methods = array();
  
  /**
   * 
   * @param string $methodName
   * @param string $methodGroup
   * @param string $methodClass
   * @throws \Exception
   */
  public function add($methodName, $methodGroup, $methodClass){
    
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
    if( isset($this->methods[$methodName]) ){
      throw new \Exception('RPCMethodStorage: Add dublicate method >>' . $methodName . '<<');
    }
    
    // если все хорошо то добавляем
    $this->methods[$methodName] = [
      'group' => $methodGroup,
      'class' => $methodClass,
    ];
  }
  
  /**
   * @return array || false
   */
  public function getMethodInfo($methodName) {
    if( !isset($this->methods[$methodName]) ){
      return false;
    }
    return $this->methods[$methodName];
  }
}
