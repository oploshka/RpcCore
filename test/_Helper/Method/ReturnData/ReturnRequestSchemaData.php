<?php

namespace Oploshka\RpcTestHelper\Method\ReturnData;

class ReturnRequestSchemaData extends \Oploshka\RpcAbstract\Method {
  
  public static function description() { return ''; }
  public static function requestSchema() {
    return [
      'string'  => ['type' => 'string', 'validate' => [], 'req' => false ],
      'int'     => ['type' => 'int'   , 'validate' => [], 'req' => false ],
      'float'   => ['type' => 'float' , 'validate' => [], 'req' => false ],
      'origin'  => ['type' => 'origin', 'validate' => [], 'req' => false ],
    ];
  }
  public static function responseSchema(){ return []; }
  
  public function run(){
    $this->Response->setData('string' , $this->Data['string'] );
    $this->Response->setData('int'    , $this->Data['int']    );
    $this->Response->setData('float'  , $this->Data['float']  );
    $this->Response->setData('origin' , $this->Data['origin'] );
  
    $this->Response->setErrorCode('ERROR_NO');
  }
}
