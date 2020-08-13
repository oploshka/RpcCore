<?php

namespace Oploshka\RpcHelperTest\Method;

class MethodTestLogger extends \Oploshka\Rpc\Method {
  
  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }
  
  public static function requestSchema(){
    return [];
  }
  
  public function run(){
    $this->Logger->info('testLog', ['testLogKey' => 'testLogValue']);
    $this->Response->setError('ERROR_NO', 'errorMessage', ['errorKey' => 'errorValue']);
  }

  public static function responseSchema(){
    return [];
  }
  
}
