<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcExample\Enum\MethodError;

class FakeAuth extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected FakeAuthRequest $Data;
  
  public function run() {
  
    $login = $this->Data->getLogin();
    $pass = $this->Data->getPassword();
    
    if($login !== 'user' || $pass !== '123456' ){
      $this->setErrorCode('ERROR_LOGIN_PASSWORD');
    }
  
    $this->setData('session', '1234567890123456789012345678901234567890');
    $this->setErrorCode(MethodError::ERROR_NO);
  }
  
}
