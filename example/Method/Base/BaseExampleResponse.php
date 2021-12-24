<?php

namespace Oploshka\RpcExample\Method\Base;

class BaseExampleResponse {
  
  public static function schema(): array {
    return [
        'login'     => ['type' => 'string', 'validate' => [], 'req' => true ],
        'password'  => ['type' => 'string', 'validate' => [], 'req' => true ],
    ];
  }
}
