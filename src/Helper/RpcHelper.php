<?php

namespace Oploshka\Rpc;

class RpcHelper {
  
  /**
   * Header control
   */
  private $headerSettings = [
    'Access-Control-Allow-Origin' => '*',
  ];
  public function setHeaderSettings($settings) {
    $this->headerSettings = $settings;
  }
  public function getHeaderSettings() {
    return $this->headerSettings;
  }
  public function applyHeaderSettings() {
    if ($this->headerSettings !== [] && headers_sent()) {
      return false;
    }
    foreach ($this->headerSettings as $k => $v){
      header("{$k}: {$v}");
    }
    return true;
  }
  
  /**
   * Php ini control
   */
  private $phpSettings = [
    'error_reporting'         => E_ALL,
    'display_errors'          => 1,
    'display_startup_errors'  => 1,
    'date.timezone'           => 'UTC',
  ];
  public function setPhpSettings($settings) {
    $this->phpSettings = $settings;
  }
  public function getPhpSettings() {
    return $this->headerSettings;
  }
  public function applyPhpSettings() {
    $log = [];
    foreach ($this->phpSettings as $k => $v){
      try{
        ini_set($k, $v);
      } catch (\Exception $e){
        $log[] = $e->getMessage();
      }
    }
    return $log === [] ? true : $log;
  }
  
}
