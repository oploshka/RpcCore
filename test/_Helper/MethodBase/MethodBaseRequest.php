<?php

namespace Oploshka\RpcTestHelper\MethodBase;

use Oploshka\RpcInterface\iRpcMethodRequest;

class MethodBaseRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [
        'login'     => ['type' => 'string', 'validate' => [], 'req' => true ],
        'password'  => ['type' => 'string', 'validate' => [], 'req' => true ],
    ];
  }
 
  protected string $login;
  protected string $password;
  
  
  // TODO: use init function by array
  public function __construct() {
    $this->login    = 'test';
    $this->password = 'user';
  }
 
  public function getLogin(): string {
    return $this->login;
  }
  public function getPassword(): string {
    return $this->password;
  }
 
}
