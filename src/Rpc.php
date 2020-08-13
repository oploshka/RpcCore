<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\ReformDebug;
use Oploshka\RpcException\RpcException;

class Rpc {
  
  // валидация данных
  private $Reform;
  // логер
  private $Logger;
  //
  private $RpcMethodStorage;
  // обработка данных запроса/ответа
  private $RpcRequestLoad;
  private $RpcRequestFormatter;
  private $RpcRequestStructure;
  private $RpcResponseFormatter;
  private $RpcResponseStructure;
  // TODO: что это?
  private $ResponseClass;   // именно класс, а не обьект Класса
  // TODO // private $ErrorStorage;    // данные по ошибкам // TODO: передавать в $ReturnFormatter
  
  // getters
  
  /*
   * @return \Oploshka\Rpc\RpcMethodStorage
   **/
  public function getRpcMethodStorage()     { return $this->RpcMethodStorage;     }
  //
  public function getRpcRequestLoad()       { return $this->RpcRequestLoad;       }
  public function getRpcRequestFormatter()  { return $this->RpcRequestFormatter;  }
  public function getRpcRequestStructure()  { return $this->RpcRequestStructure;  }
  public function getRpcResponseFormatter() { return $this->RpcResponseFormatter; }
  public function getRpcResponseStructure() { return $this->RpcResponseStructure; }
  
  // setters
  // TODO: add setters

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
  public function __construct($obj = []) {
  
    $this->Reform                       = $obj['Reform']        ?? new ReformDebug();
    // TODO: логер
    // $this->Logger                       = $obj['Logger']        ?? new Logger();
    //
    $this->RpcMethodStorage             = $obj['RpcMethodStorage'] ?? new RpcMethodStorage();
    // обработка данных запроса/ответа
    $this->RpcRequestLoad       = $obj['RpcRequestLoad']       ?? new \Oploshka\RpcRequestLoad\Post_MultipartFormData_Field();
    $this->RpcRequestFormatter  = $obj['RpcRequestFormatter' ] ?? new \Oploshka\RpcFormatter\Json();
    $this->RpcRequestStructure  = $obj['RpcRequestStructure' ] ?? new \Oploshka\RpcStructure\MultipartJsonRpc_v0_1();
    $this->RpcResponseFormatter = $obj['RpcResponseFormatter'] ?? new \Oploshka\RpcFormatter\Json();
    $this->RpcResponseStructure = $obj['RpcResponseStructure'] ?? new \Oploshka\RpcStructure\MultipartJsonRpc_v0_1();
  
    // TODO
    $this->ResponseClass = '\Oploshka\Rpc\RpcMethodResponse';
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
      $loadStr = $this->RpcRequestLoad->load();
      // расшифруем
      $loadData = $this->RpcRequestFormatter->decode($loadStr);
      // считываем структуру
      $RpcMethodInfoObj = $this->RpcRequestStructure->decode($loadData);
      // запустим метод
      $RpcMethodResponseObj = $this->runMethod($RpcMethodInfoObj); // TODO: подумать по названиям
      //
      // создаем структуру
      $RpcRequestObj = $this->RpcResponseStructure->encode($loadData);
      
      // TODO: опционально вернуть обьект или выводить содержимое
      // отдаем ответ
      $this->RpcResponseFormatter->printResponse($loadStr);
      
    } catch (\Throwable $e) {
      // TODO: fix
    }
    
  }
  
  /**
   * Run Rpc method
   *
   * @param RpcMethodInfo     $RpcMethodInfoObj
   *
   * @return RpcMethodResponse
   **/
  public function runMethod($RpcMethodInfoObj) {
    ob_start();
    // ErrorHandler::add();
    
    // это нужно для корректного закрытия ob_start
    $Response = $this->runMethodProcessing($RpcMethodInfoObj);
  
    // проверим что в ответе не шляпа а RpcMethodResponse
    if( !$this->isResponse($Response)) {
      $responseLink = $Response;
    
      /** @var RpcMethodResponse  */
      $Response = new $this->ResponseClass();
    
      $errorData = [
        'gettype' => gettype($responseLink)
      ];
      if( gettype ( $responseLink ) == 'object' ) {
        $errorData['get_class'] = get_class($responseLink);
      }
    
      $Response->setError(
        new Error([
          'code'    => 'ERROR_NOT_CORRECT_METHOD_RETURN',
          'data'    => $errorData
        ])
      );
    }
    
    $echo = ob_get_contents();
    if($echo !== ''){
      // TODO: fix
      $this->Logger->warning('echo', $echo );
    }
  
    // ErrorHandler::remove();
    ob_end_clean();
    return $Response;
  }

  /**
   * Run Rpc method
   *
   * @param RpcMethodInfo     $RpcMethodInfoObj
   *
   * @return RpcMethodResponse
   **/
  private function runMethodProcessing($RpcMethodInfoObj) {
  
  
    try {
      /** @var RpcMethodResponse $Response  */
      $Response = new $this->ResponseClass();
      //
      $methodName = $RpcMethodInfoObj->getMethodName();
      $methodData = $RpcMethodInfoObj->getData();
      
      $MethodClassName = $this->getMethodClassNameForMethodName($methodName);
  
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
  
      $MethodClass = new $MethodClassName( [
        'response'  => $Response,
        'data'      => $data,
        'logger'    => $this->Logger,
      ] );
      $returnResponse = $MethodClass->run();
      if( $returnResponse !== null && $this->isResponse($returnResponse)) {
        $Response = $returnResponse;
      }
      
    } catch (\Oploshka\RpcException\MethodEndException $e) {
      // вызвано $Response->error() - завершение метода, обработка ошибок не нужна
    } catch (RpcException $e) {
      $Response->setErrorCode($e->getMessage());
      return $Response;
    }
    catch (\Throwable $e ) {
      $Response = new $this->ResponseClass();
      $Response->setError(
        new Error([
          'code'    => 'ERROR_METHOD_RUN',
          'message' => $e->getMessage(),
          'data'    => [
            'methodName' => $methodName,
            'methodData' => $methodData,
            'code' => $e->getCode(),
            'line' => $e->getLine(),
          ]
        ])
      );
    }
  
    return $Response;
  }
  
  // $Response is Response class?
  public function isResponse($Response) {
    $responseType = gettype ( $Response );
    if( $responseType === 'object' && get_class ( $Response ) != 'Oploshka\Rpc\RpcMethodResponse'){
      return false;
    }
    return true;
  }
  
  
  public function getMethodClassNameForMethodName($methodName){
  
    // get method info
    $methodInfo = $this->RpcMethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      throw new RpcException('ERROR_NO_METHOD');
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
    ///#   throw new \Exception('ERROR_NOT_INSTANCEOF_INTERFACE');
    ///# }
  
    $interfaces = class_implements( $MethodClassName );
    if ( !isset( $interfaces['Oploshka\RpcInterface\Method'] ) ) {
      // var_dump($interfaces);
      throw new \RpcException('ERROR_NOT_INSTANCEOF_INTERFACE');
    }
    
    return $MethodClassName;
  }
  
  
}
