<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcContract\iRpcMethodRequest;

class ValidateBasicDateTypeRequest implements iRpcMethodRequest {
 
  public static function schema(): array {
    return [
        'string'  => ['type' => 'string', 'validate' => [], 'req' => false ],
        'int'     => ['type' => 'int'   , 'validate' => [], 'req' => false ],
        'float'   => ['type' => 'float' , 'validate' => [], 'req' => false ],
        'origin'  => ['type' => 'origin', 'validate' => [], 'req' => false ],
    ];
  }
  
  protected array $data;
  
  public function __construct(array $data) {
    $this->data = $data;
  }
  
  public function getString() : ?string { return $this->data['string'] ?? null; }
  public function getInt()    : ?int    { return $this->data['int']    ?? null; }
  public function getFloat()  : ?float  { return $this->data['float']  ?? null; }
  public function getOrigin()           { return $this->data['origin'] ?? null; }
  
}
