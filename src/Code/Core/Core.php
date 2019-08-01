<?php

namespace Oploshka\Rpc;

class Core implements \Oploshka\RpcInterface\Core {

  private $MethodStorage;   // храним данные по методам
  private $Reform;          // валидация данных
  private $DataLoader;      // загрузка данных
  private $DataFormatter;   //
  private $ReturnFormatter; // в каком формате отдавать данные
  private $ResponseClass;   // именно класс, а не обьект Класса

  private $Logger;          // храним данные по методам
  // TODO // private $ErrorStorage;    // данные по ошибкам // TODO: передавать в $ReturnFormatter

  /**
   * Core constructor.
   *
   * TODO: add interface MethodStorage
   *
   * @param $obj array
   *  - MethodStorage
   *  - Reform
   *  - DataLoader
   *  - ReturnFormatter
   *  - ResponseClass
   *  - DataFormatter
   */
  public function __construct($obj) {
    $this->MethodStorage    = $obj['methodStorage'];
    $this->Reform           = $obj['reform'];
    $this->DataLoader       = $obj['dataLoader'];
    $this->DataFormatter    = $obj['dataFormatter'];
    $this->ReturnFormatter  = $obj['returnFormatter'];
    $this->ResponseClass    = $obj['responseClass']; // TODO: \Oploshka\Rpc\Response;

    $this->Logger           = isset($obj['logger']) ? $obj['logger'] : new Logger();
    // TODO // $this->ErrorStorage     = new \Oploshka\Rpc\ErrorStorage(); // TODO: delete;
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
   * @return Response
   */
  public function startProcessingRequest() {
    // data load
    $requestType = 'single';
    $loadData = [];
    $loadStatus = $this->DataLoader->load($loadData);
    if($loadStatus !== 'ERROR_NO'){
      $Response = new $this->ResponseClass();
      $Response->setError($loadStatus);
      return $this->ReturnFormatter->format([
        'requestType'   => $requestType,
        'responseList' => [ $Response ],
        // 'loadData'     => [],
        // 'methodList'   => [],
        'logger'       => $this->Logger,
      ]);
    }

    // validate format required field
    $methodList = [];
    $validateStatus = $this->DataFormatter->prepare($loadData, $methodList, $requestType);
    if($validateStatus !== 'ERROR_NO'){
      $Response = new $this->ResponseClass();
      $Response->setError($validateStatus);
      return $this->ReturnFormatter->format([
        'requestType'   => $requestType,
        'responseList' => [ $Response ],
        // 'loadData'     => [],
        // 'methodList'   => [],
        'logger'       => $this->Logger,
      ]);
    }

    // run method
    // validate format required field
    $responseList = [];
    foreach ($methodList as $methodItem){
      $responseList[] = $this->startProcessingMethod($methodItem['method'], $methodItem['params']);
    }
    
    return $this->ReturnFormatter->format( [
      'requestType'  => $requestType,
      'loadData'     => $loadData,
      'methodList'   => $methodList,
      'responseList' => $responseList,
      'logger'       => $this->Logger,
    ]);

  }
  

  /**
   * Run Rpc method
   *
   * @param string $methodName string
   * @param array $methodData array
   *
   * @return Response
   */
  public function startProcessingMethod($methodName, $methodData ) {

    $Response = new $this->ResponseClass();
    ob_start();
    ErrorHandler::add();
    try{
      $Response = $this->runMethod($methodName, $methodData, $Response);
    } catch (Exception $e){
      $this->Logger->error('runMethodError', $e->getMessage() );
      $Response->setError('ERROR_METHOD_RUN');
      // return $Response;
    }

    $echo = ob_get_contents();
    if($echo !== ''){
      $this->Logger->warning('echo', $echo );
    }

    ErrorHandler::remove();
    ob_end_clean();
    
    return $Response;
  }

  private function runMethod($methodName, $methodData, $Response) {

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
    $MethodClass = new $MethodClassName( [
      'response'  => false,
      'data'      => false,
      'logger'    => false,
    ] );

    // validate class interface
    if ( !($MethodClass instanceof \Oploshka\RpcInterface\Method) ) {
      $Response->setError('ERROR_NOT_INSTANCEOF_INTERFACE');
      return $Response;
    }

    // validate method data
    $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClass::validate()] );
    if($data === null) {
      $Response->setError('ERROR_NOT_VALIDATE_DATA');
      return $Response;
    }

    $responseLink = clone $Response;
    try {
      $MethodClass = new $MethodClassName( [
        'response'  => $Response,
        'data'      => $data,
        'logger'    => $this->Logger,
      ] );
      $MethodClass->run();
    } catch (MethodEndException $e) {

    } catch (\Throwable $e ){
      $responseLink->setError('ERROR_METHOD', $e->getMessage(), [
        'methodName' => $methodName,
        'methodData' => $methodData,
        'code' => $e->getCode(),
        'line' => $e->getLine(),
      ]);
      return $responseLink;
    }

    // $Response is Response class?
    $responseType = gettype ( $Response );
    if( $responseType === 'object' && get_class ( $Response ) != 'Oploshka\Rpc\Response'){

      $this->Logger->error('responseErrorType', ['gettype' => gettype($Response)] );
      if( gettype ( $Response ) == 'object' ) {
        $this->Logger->error('responseErrorClass',  ['get_class' => get_class($Response)] );
      }

      $responseLink->setError('ERROR_NOT_CORRECT_METHOD_RETURN');
      // reset response
      $Response = $responseLink;
    }

    return $Response;
  }
  
}