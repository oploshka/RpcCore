<?php

namespace Rpc\Utils;

/*
 * Клас для ответа
 */
class Response {
  
  private $error    = 'ERROR_DEFAULT' ;
  private $info     = array();
  private $logs     = array();
  
  public function infoAdd($key, $value){
    if($key == 'logs' || $key == 'error' || $key == 'message'){ $this->error('ERROR_INFO_ADD_KEY_'.$key); }
    $this->info[$key] = $value;
  }
  //
  public function logAdd($log = ''){
    if($log != ''){ $this->logs[] = $log; }
  }
  
  public function error($error_name, $message = NULL){
    $this->error = $error_name;
    if($message !== NULL ){
      $this->message = $message;
    }
    throw new \Exception('');
  }
  
  // ответ
  public function getResponse() {
    $result = $this->info;
    $result['error'] = $this->error;
    if($this->logs !== array() )     { $result['logs'] = $this->logs;    }
    return $result;
  }
  
}