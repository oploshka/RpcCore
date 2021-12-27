<?php

namespace Oploshka\RpcExample\Method\Simple;

use Oploshka\RpcExample\Enum\MethodError;

class ValidateBasicDateType extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  protected ?ValidateBasicDateTypeRequest $Data = null;
  
  public function run() {
    $this->Response->setData('string' , $this->Data->getString()  );
    $this->Response->setData('int'    , $this->Data->getInt()     );
    $this->Response->setData('float'  , $this->Data->getFloat()   );
    $this->Response->setData('origin' , $this->Data->getOrigin()  );
    
    $this->setErrorCode(MethodError::ERROR_NO);
  }
  
}
