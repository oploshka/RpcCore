<?php

namespace Oploshka\Rpc\Plugin\RpcContentLoad;

class Post_MultipartFormData_Field {

  private $filed ;
  
  function  __construct($filed = 'data'){
    $this->filed = $filed;
  }
  
  public function load(){
  
    // Request method is post
    if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
      // throw new \Oploshka\RpcException\ReformException('ERROR_REQUEST_METHOD_TYPE');
      // TODO: fix
      throw new \Exception('ERROR_REQUEST_METHOD_TYPE');
    }
    // Post is empty
    if($_POST == [] ) {
      // throw new \Oploshka\RpcException\ReformException('ERROR_POST_EMPTY');
      // TODO: fix
      throw new \Exception('ERROR_POST_EMPTY');
    }
    // $_POST['data']  not send
    if( !isset($_POST[$this->filed]) ) {
      // throw new \Oploshka\RpcException\ReformException('ERROR_POST_DATA_NULL');
      // TODO: fix
      throw new \Exception('ERROR_POST_DATA_NULL');
    }
    
    return $_POST[$this->filed];
  }
  
}
