<?php

namespace Oploshka\RpcMethods;

class SystemEcho extends \Oploshka\Rpc\Method {

  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }

  public static function requestSchema(){
    return [];
  }

  // TODO: реализовать...
  public function run(){
    $this->Response->error('ERROR_NO');
  }

  public static function responseSchema(){
    return [];
  }
}
