<?php

namespace Oploshka\Rpc;

class Core {
  
  private $MethodStorage;   // храним данные по методам
  private $Reform;          // валидация данных
  private $DataLoader;      // загрузка данных
  // private $ErrorStorage;    // данные по ошибкам // TODO: передавать в $ReturnFormatter
  private $ReturnFormatter; // в каком формате отдавать данные
  private $ResponseClass;   // именно класс, а не обьект Класса

  /**
   * Core constructor.
   *
   * TODO: add interface iMethodStorage
   *
   * @param iMethodStorage $MethodStorage
   * @param $Reform
   * @param iDataLoader       $DataLoader
   * @param iReturnFormatter  $ReturnFormatter
   * @param $ResponseClass
   */
  public function __construct($MethodStorage, $Reform, $DataLoader, $ReturnFormatter, $ResponseClass) {
    $this->MethodStorage    = $MethodStorage;
    $this->Reform           = $Reform;
    $this->DataLoader       = $DataLoader;
    $this->ReturnFormatter  = $ReturnFormatter;
    $this->ResponseClass    = $ResponseClass; // TODO: \Oploshka\Rpc\Response;
  }
  
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
  
  /**
   * @param Response $Response
   * @param iDataLoader $DataLoader
   * @param iReturnFormatter $Formatter
   * @param iErrorStorage $ErrorStore
   *
   * @return Response
   */
  public function autoRun() {
    $methodName = '';
    $methodData = [];
    $loadData = [];
    // data load
    $loadStatus = $this->DataLoader->load($loadData);
    if($loadStatus !== 'ERROR_NOT'){
      $Response = new $this->ResponseClass();
      $Response->setError($loadStatus);
      return $Response;
    }
    // validate format required field
    $validateStatus = $this->ReturnFormatter->prepare($loadData, $methodName, $methodData);
    if($validateStatus !== 'ERROR_NOT'){
      $Response = new $this->ResponseClass();
      $Response->setError($validateStatus);
      return $Response;
    }
    // run method
    $Response = $this->runMethod($methodName, $methodData);
    
    return $this->ReturnFormatter->format($methodName, $methodData, $Response);
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
  public function runMethod($methodName, $methodData ) {

    $Response = new $this->ResponseClass();
    ob_start();
    try{
      $Response = $this->runMethodOb($methodName, $methodData, $Response);

    } catch (Exception $e){
      $Response->setLog( 'runMethodError', $e->getMessage() );
      $Response->setError('ERROR_METHOD_RUN');
      return $Response;
    }
    $Response->setLog('echo', ob_get_contents() );
    ob_end_clean();
    
    return $Response;
  }

  private function runMethodOb($methodName, $methodData, $Response) {

    // validate method name
    if( !is_string($methodName) || $methodName == '') {
      $Response->setError('ERROR_NO_METHOD_NAME');
      return $Response;
    }

    // get method info
    $methodInfo = $this->MethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      $Response->setError('ERROR_NO_METHOD_INFO');
      return $Response;
    }

    // method class create
    $MethodClassName = $methodInfo['class'];
    $MethodClass = new $MethodClassName();

    // validate class interface
    if ( !($MethodClass instanceof \Oploshka\Rpc\iMethod) ) {
      $Response->setError('ERROR_NOT_INSTANCEOF_INTERFACE');
      return $Response;
    }

    // validate method data
    $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClass->validate()] );
    if($data === NULL) {
      $Response->setError('ERROR_NOT_VALIDATE_DATA');
      return $Response;
    }

    $responseLink = $Response;
    try {
      $MethodClass->run($Response, $data);
    } catch (\Exception $e) {
      $Response->setLog('methodRun', $e->getMessage());
    }

    // $Response is Response class?
    $responseType = gettype ( $Response );
    if( $responseType === 'object' && get_class ( $Response ) != 'Oploshka\Rpc\Response'){

      $responseLink->setLog( 'responseErrorType', gettype($Response) );
      if( gettype ( $Response ) == 'object' ) {
        $Response->setLog( 'responseErrorClass', get_class($Response) );
      }

      $responseLink->setError('ERROR_NOT_CORRECT_METHOD_RETURN');
      // reset response
      $Response = $responseLink;
    }

    return $Response;
  }
  
}