<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodTestData extends \Oploshka\Rpc\Method {
  
  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }
  
  public static function validate(){
    return [
      'string'  => ['type' => 'string', 'validate' => [], 'req' => false ],
      'int'     => ['type' => 'int'   , 'validate' => [], 'req' => false ],
      'float'   => ['type' => 'float' , 'validate' => [], 'req' => false ],
      'origin'  => ['type' => 'origin', 'validate' => [], 'req' => false ],
    ];
  }
  
  public function run(){
    $this->Response->setData('string' , $this->Data['string'] );
    $this->Response->setData('int'    , $this->Data['int']    );
    $this->Response->setData('float'  , $this->Data['float']  );
    $this->Response->setData('origin' , $this->Data['origin'] );

    $this->Response->setError('ERROR_NO');
  }

  public static function return(){
    return [];
  }
  
}