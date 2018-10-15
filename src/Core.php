<?php

namespace Oploshka\Rpc;

use PHPUnit\Runner\Exception;

class Core {
  
  private $MethodStorage;
  private $Reform;
  private $LoadData;
  private $Response;

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
    $this->LoadData       = [];
    $this->Response       = new Response();
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
      $this->Response->error('ERROR_SET_HEADER', false);
      return $this->Response;
    }
    
    foreach ($this->headerSettings as $k => $v){
      header("{$k}: {$v}");
    }
  
    try{
      foreach ($this->phpSettings as $k => $v){
        ini_set($k, $v);
      }
    } catch (Exception $e){
      $this->Response->logAdd( $e->getMessage() );
      $this->Response->error('ERROR_INI_SET', false);
      return $this->Response;
    }
    
    try{
      $response = $this->runMethod($methodName, $methodData);
    } catch (Exception $e){
      $this->Response->logAdd( $e->getMessage() );
      $this->Response->error('ERROR_METHOD_RUN', false);
      return $this->Response;
    }

    $this->Response->logAdd( ob_get_contents() );
    ob_end_clean();
    
    return $response;
  }
  
  private function runMethod($methodName, $methodData){

    // validate method name
    if( !is_string($methodName) || $methodName == '') {
      $this->Response->error('ERROR_NO_METHOD_NAME', false);
      return $this->Response;
    }
  
    // get method info
    $methodInfo = $this->MethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      $this->Response->error('ERROR_NO_METHOD_INFO', false);
      return $this->Response;
    }
  
    // method class create
    $MethodClassName = $methodInfo['class'];
    $MethodClass = new $MethodClassName();
  
    // validate class interface
    if ( !($MethodClass instanceof \Oploshka\Rpc\Method) ) {
      $this->Response->error('ERROR_NOT_INSTANCEOF_INTERFACE', false);
      $this->Response->logAdd();
      return $this->Response;
    }
  
    // validate method data
    $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClass->validate()] );
    if($data === NULL) {
      $this->Response->error('ERROR_NOT_VALIDATE_DATA', false);
      return $this->Response;
    }

    $responseLink = $this->Response;
    try {
      $MethodClass->run($this->Response, $data);
    } catch (\Exception $e) {
      $this->Response->logAdd( $e->getMessage());
    }
  
    // проверим что метод не убил класс ответа
    if( gettype ( $this->Response ) != 'object' || get_class ( $this->Response ) != 'Oploshka\Rpc\Response'){
      // Класс убил наш ответ, реанимируем его
      $responseError = $this->Response;
      $this->Response = $responseLink;
      // запишем инфу в логи для дебага
      $this->Response->logAdd( 'gettype = ('   . gettype( $responseError )   . ');' );
      if( gettype ( $this->Response ) == 'object' ) {
        $this->Response->logAdd( 'get_class = (' . get_class( $responseError ) . ');' );
      }
      $this->Response->error('ERROR_NOT_CORRECT_METHOD_RETURN', false);
    }
    
    return $this->Response;
  }
  
}