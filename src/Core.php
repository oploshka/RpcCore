<?php

namespace Oploshka\Rpc;

use PHPUnit\Runner\Exception;

class Core {
  
  private $MethodStorage;
  private $Reform;
  private $headerSettings = [
    'Access-Control-Allow-Origin' => '*',
  ];
  private $phpSettings = [
    'error_reporting'         => E_ALL,
    'display_errors'          => 1,
    'display_startup_errors'  => 1,
    'date.timezone'           => 'UTC',
  ];
  
  public function __construct($MethodStorage, $Reform) {
    $this->MethodStorage  = $MethodStorage;
    $this->Reform         = $Reform;
  }
  
  /**
   * @param array $settings
   */
  public function setHeaderSettings($settings) {
    $this->headerSettings = $settings;
  }
  public function getHeaderSettings() {
    return $this->headerSettings;
  }
  
  /**
   * @param array $settings
   */
  public function setPhpSettings($settings) {
    $this->phpSettings = $settings;
  }
  public function getPhpSettings() {
    return $this->headerSettings;
  }
  
  /**
   * Run Rpc method
   *
   * @param string $methodName string
   * @param array $methodData array
   *
   * @return Response
   *
   */
  public function run($methodName, $methodData) {
  
    ob_start();
    if ($this->headerSettings !== [] && headers_sent()) {
      $response  = new Response();
      $response->error('ERROR_SET_HEADER', false);
      return $response;
    }
    
    foreach ($this->headerSettings as $k => $v){
      header("{$k}: {$v}");
    }
  
    try{
      foreach ($this->phpSettings as $k => $v){
        ini_set($k, $v);
      }
    } catch (Exception $e){
      $response  = new Response();
      $response->logAdd( $e->getMessage() );
      $response->error('ERROR_INI_SET', false);
      return $response;
    }
    
    try{
      $response = $this->runMethod($methodName, $methodData);
    } catch (Exception $e){
      $response  = new Response();
      $response->logAdd( $e->getMessage() );
      $response->error('ERROR_METHOD_RUN', false);
      return $response;
    }
  
    $response->logAdd( ob_get_contents() );
    ob_end_clean();
    
    return $response;
  }
  
  private function runMethod($methodName, $methodData){
  
    // Response init
    $response  = new Response();
  
    // validate method name
    if( !is_string($methodName) || $methodName == '') {
      $response->error('ERROR_NO_METHOD_NAME', false);
      return $response;
    }
  
    // get method info
    $methodInfo = $this->MethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      $response->error('ERROR_NO_METHOD_INFO', false);
      return $response;
    }
  
    // method class create
    $MethodClassName = $methodInfo['class'];
    $MethodClass = new $MethodClassName();
  
    // validate class interface
    if ( !($MethodClass instanceof \Oploshka\Rpc\Method) ) {
      $response->error('ERROR_NOT_INSTANCEOF_INTERFACE', false);
      $response->logAdd();
      return $response;
    }
  
    // validate method data
    $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClass->validate()] );
    if($data === NULL) {
      $response->error('ERROR_NOT_VALIDATE_DATA', false);
      return $response;
    }
  
    try {
      $MethodClass->run($response, $data);
    } catch (\Exception $e) {
      $response->logAdd( $e->getMessage());
    }
  
    // проверим что метод не убил класс ответа
    if( gettype ( $response ) != 'object' || get_class ( $response ) != 'Oploshka\Rpc\Response'){
      // Класс убил наш ответ, реанимируем его
      $_response = $response;
      $response = new Response();
      // запишем инфу в логи для дебага
      $response->logAdd( 'gettype = ('   . gettype( $_response )   . ');' );
      if( gettype ( $response ) == 'object' ) {
        $response->logAdd( 'get_class = (' . get_class( $_response ) . ');' );
      }
      $response->error('ERROR_NOT_CORRECT_METHOD_RETURN', false);
    }
    
    return $response;
  }
  
}