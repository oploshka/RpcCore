<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcContract\iRpcMethodRequest;

class FakeAuthRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [
        'login'     => ['type' => 'string', 'validate' => [], 'req' => true ],
        'password'  => ['type' => 'string', 'validate' => [], 'req' => true ],
    ];
  }
  
  protected array $data;
  
  public function __construct(array $data) {
    $this->data = $data;
  }
  
  public function getLogin(): string {
    return $this->data['login'];
  }
  public function getPassword(): string {
    return $this->data['password'];
  }
  
}
