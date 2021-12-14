<?php

namespace Oploshka\RpcTestHelper\MethodBase;

use Oploshka\RpcInterface\iRpcMethodRequest;

class BaseIRpcMethodRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [
        'login'     => ['type' => 'string', 'validate' => [], 'req' => true ],
        'password'  => ['type' => 'string', 'validate' => [], 'req' => true ],
    ];
  }
 
  protected string $login;
  protected string $password;
 
  public function getLogin(): string {
    return $this->login;
  }
  public function getPassword(): string {
    return $this->password;
  }
 
}
