<?php

namespace Oploshka\Rpc;

class RpcMethodStorage implements \Oploshka\RpcContract\iRpcMethodStorage {
  
  private $methodList = [];
  
  /**
   * @throws \Exception
   */
  public function add(string $methodName, string $methodClass, string $methodGroup = 'default'){
    
    // Запрет переопределения существующего метода
    if( isset($this->methods[$methodName]) ){
      throw new \Exception('RPCMethodStorage: Add dublicate method >>' . $methodName . '<<');
    }
    
    // если все хорошо то добавляем
    $this->methodList[$methodName] = [
      'name'  => $methodName,
      'class' => $methodClass,
      'group' => $methodGroup,
    ];
  }
  
  public function getMethodInfo(string $methodName) :?array {
    if( !isset($this->methodList[$methodName]) ){
      return null;
    }
    return $this->methodList[$methodName];
  }
}
