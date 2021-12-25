<?php

namespace Oploshka\Rpc\Plugin\RpcContentLoad;

use Oploshka\RpcException\RpcException;

class Post_MultipartFormData_Field {

  private string $filed;
  
  function  __construct(string $filed = 'data'){
    $this->filed = $filed;
  }
  
  public function load(){
  
    // Request method is post
    if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new RpcException('ERROR_REQUEST_METHOD_TYPE');
    }
    // Post is empty
    if($_POST == [] ) {
      throw new RpcException('ERROR_POST_EMPTY');
    }
    // $_POST['data']  not send
    if( !isset($_POST[$this->filed]) ) {
      throw new RpcException('ERROR_POST_DATA_NULL');
    }
    
    return $_POST[$this->filed];
  }
  
}
