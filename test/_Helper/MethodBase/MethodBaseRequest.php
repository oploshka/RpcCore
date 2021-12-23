<?php

namespace Oploshka\RpcTestHelper\MethodBase;

use Oploshka\RpcContract\iRpcMethodRequest;

class MethodBaseRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [
        'login'     => ['type' => 'string', 'validate' => [], 'req' => true ],
        'password'  => ['type' => 'string', 'validate' => [], 'req' => true ],
    ];
  }
  
  protected array $data;
  
  public function __construct(array $data) {
    // TODO: add validate by schema
    $this->data = $data;
  }
  
  
  public function getData(): array {
    return $this->data;
  }
  public function getLogin(): string {
    return $this->data['login'];
  }
  public function getPassword(): string {
    return $this->data['password'];
  }
  
  /*
  // вариант 1 более правильный
  protected string $login;
  protected string $password;
  
  
  public function __construct($arr) {
    $this->login    = 'test';
    $this->password = 'user';
  }
 
  public function getLogin(): string {
    return $this->login;
  }
  public function getPassword(): string {
    return $this->password;
  }
  */
}
