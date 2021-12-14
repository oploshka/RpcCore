<?php

namespace Oploshka\RpcTestHelper\MethodBase;

class MethodBaseResponse {
  
  public static function schema(): array {
    return [
        'login'     => ['type' => 'string', 'validate' => [], 'req' => true ],
        'password'  => ['type' => 'string', 'validate' => [], 'req' => true ],
    ];
  }
}
