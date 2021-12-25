<?php

namespace Oploshka\RpcExample\Method\Simple;

class FakeAuthResponse {
  
  public static function schema(): array {
    return [
        'session' => ['type' => 'string', 'validate' => [], 'req' => true],
    ];
  }
  
}
