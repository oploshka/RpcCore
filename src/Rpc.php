<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\ReformDebug;

class Rpc implements \Oploshka\RpcInterface\Core {
  
  // валидация данных
  private $Reform;
  // логер
  private $Logger;
  //
  private $RpcMethodStorage;
  // обработка данных запроса/ответа
  private $RpcRequestLoader;
  private $RpcRequestLoaderFormatter;
  private $RpcRequestLoaderStructure;
  private $RpcResponseLoaderFormatter;
  private $RpcResponseLoaderStructure;
  // TODO: что это?
  private $ResponseClass;   // именно класс, а не обьект Класса

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
  
    $this->Reform                       = $obj['Reform']        ?? new ReformDebug();
    // логер
    $this->Logger                       = $obj['Logger']        ?? new Logger();
    //
    $this->RpcMethodStorage             = $obj['RpcMethodStorage'] ?? new RpcMethodStorage();
    // обработка данных запроса/ответа
    $this->RpcRequestLoader             = $obj['RpcRequestLoader'          ] ?? new \Oploshka\RpcLoaderFormatter\Post_MultipartFormData_Field();
    $this->RpcRequestLoaderFormatter    = $obj['RpcRequestLoaderFormatter' ] ?? new \Oploshka\RpcLoaderFormatter\Json();
    $this->RpcRequestLoaderStructure    = $obj['RpcRequestLoaderStructure' ] ?? new \Oploshka\RpcLoaderStructure\MultipartJsonRpc_v0_1();
    $this->RpcResponseLoaderFormatter   = $obj['RpcResponseLoaderFormatter'] ?? new \Oploshka\RpcLoaderFormatter\Json();
    $this->RpcResponseLoaderStructure   = $obj['RpcResponseLoaderStructure'] ?? new \Oploshka\RpcLoaderStructure\MultipartJsonRpc_v0_1();
  }
  
  // TODO: add get and set method for private var
  
  
  
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
   * @return RpcMethodResponse
   */
  public function startProcessingRequest() {
  
    try {
      // получим данные
      $loadStr = $this->RpcRequestLoader->load();
      // расшифруем
      $loadData = $this->RpcRequestLoaderFormatter->decode($loadStr);
      // считываем структуру
      $RpcMethodInfoObj = $this->RpcRequestLoaderStructure->decode($loadData);
      // запустим метод
      $RpcMethodResponseObj = $this->runMethod($RpcMethodInfoObj); // TODO: подумать по названиям
      //
      // создаем структуру
      $RpcRequestObj = $this->RpcResponseLoaderStructure->encode($loadData);
      
      // TODO: опционально вернуть обьект или выводить содержимое
      // отдаем ответ
      $this->RpcResponseLoaderFormatter->printResponse($loadStr);
      
    } catch (\Throwable $e) {
      // TODO: fix
    }
    
  }
  

  /**
   * Run Rpc method
   *
   * @param string $methodName string
   * @param array $methodData array
   *
   * @return RpcMethodResponse
   */
  public function runMethod($RpcMethodInfoObj ) {

    $Response = new $this->ResponseClass();
    ob_start();
    // ErrorHandler::add();
    try{
      $Response = $this->runMethodProcessing($RpcMethodInfoObj, $Response);
    } catch (Throwable $e){
      $this->Logger->error('runMethodError', $e->getMessage() );
      $Response->setError('ERROR_METHOD_RUN');
      // return $Response;
    }

    $echo = ob_get_contents();
    if($echo !== ''){
      $this->Logger->warning('echo', $echo );
    }

    // ErrorHandler::remove();
    ob_end_clean();
    
    return $Response;
  }

  /*
   *
   * @return \Oploshka\Rpc\RpcMethodResponse
   **/
  private function runMethodProcessing($RpcMethodInfoObj, $Response) {
  
    $methodName = $RpcMethodInfoObj->getMethodName();
    $methodData = $RpcMethodInfoObj->getData();
    
    // TODO: use function getMethodClass
    try {
      $MethodClassName = $this->getMethodClassNameForMethodName($methodName);
    } catch (\Throwable $e ) {
      $Response->setError( $e->getMessage() );
      return $Response;
    }
    
    // validate method data
    $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClassName::requestSchema()] );
    if($data === null) {
      $field = [];
      $errorObjList = $this->Reform->getError();
      foreach ($errorObjList as $errorObj){
        $field[] = $errorObj['data'];
      }
      $Response->setError('ERROR_NOT_VALIDATE_DATA', '', ['field' => $field]);
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
      // вызвано $Response->error() - завершение метода, обработка ошибок не нужна
    } catch ( \Throwable $e ){
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
    if( $responseType === 'object' && get_class ( $Response ) != 'Oploshka\Rpc\RpcMethodResponse'){

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
  
  
  public function getMethodClassNameForMethodName($methodName){
  
    // get method info
    $methodInfo = $this->MethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      throw new Exception('ERROR_NO_METHOD_INFO');
    }
    
    // method class create
    $MethodClassName = $methodInfo['class'];

  
    //# TODO: переделать на class_implements и проверить работет ли
    //# https://www.php.net/manual/ru/function.class-implements.php
    //# начиная с версии PHP 5.1.0 можно передавать имя класса вместо объекта
    // validate class interface
    
    ///# $MethodClass = new $MethodClassName( [
    ///#   'response'  => false,
    ///#   'data'      => false,
    ///#   'logger'    => false,
    ///# ] );
    ///# if ( !($MethodClass instanceof \Oploshka\RpcInterface\Method) ) {
    ///#   throw new Exception('ERROR_NOT_INSTANCEOF_INTERFACE');
    ///# }
  
    $interfaces = class_implements( $MethodClassName );
    if ( !isset( $interfaces['Oploshka\RpcInterface\Method'] ) ) {
      // var_dump($interfaces);
      throw new Exception('ERROR_NOT_INSTANCEOF_INTERFACE');
    }
    
    return $MethodClassName;
  }
  
  
}
