<?php

namespace Oploshka\Rpc;

class Response {
  
  private $error    = 'ERROR_DEFAULT' ;
  private $info     = [];
  private $logs     = [];
  
  public function infoAdd($key, $value){
    $this->info[$key] = $value;
  }
  
  public function logAdd($log = ''){
    if($log != ''){ $this->logs[] = $log; }
  }
  
  public function error($errorName, $exception = true){
    $this->error = $errorName;
    if($exception){
      throw new \Exception('');
    }
  }
  
  public function getResponse() {
    $result = [
      'error'   => $this->error,
      'result'  => $this->info,
    ];
    if($this->logs !== [] ) {
      $result['logs'] = $this->logs;
    }
    return $result;
  }
  
}