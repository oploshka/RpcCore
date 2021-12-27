<?php

namespace Oploshka\Rpc\Plugin\RpcContentGet;

class ApplicationJson {

  public function load(){
   
    if(  $_SERVER["CONTENT_TYPE"] !==  'application/json' ) {
      // TODO: fix
      throw new \Exception('ERROR_CONTENT_TYPE');
    }
    $str = file_get_contents('php://input');
  
    if(  !$str ) {
      // TODO: fix
      throw new \Exception('ERROR_CONTENT_TYPE');
    }
    
    return $str;
  }
  
}
