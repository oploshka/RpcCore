<?php

namespace Oploshka\RpcRequestLoad;


class Post_MultipartFormData_Field {

  private $filed ;
  
  function  __construct($filed = 'data'){
    $this->filed = $filed;
  }
  
  public function load(&$loadData){
  
    // Request method is post
    if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
      // TODO: use throw new Exception();
      // return 'ERROR_REQUEST_METHOD_TYPE';
    }
    // Post is empty
    if($_POST == [] ) {
      // TODO: use throw new Exception();
      // return 'ERROR_POST_NULL';
    }
    // $_POST['data']  not send
    if( !isset($_POST[$this->filed]) ) {
      // TODO: use throw new Exception();
      // return 'ERROR_POST_DATA_NULL';
    }
    
    return $_POST[$this->filed];
  }
  
}
