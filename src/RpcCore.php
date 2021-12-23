<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\Reform;
use Oploshka\Reform\ReformDebug;
use Oploshka\RpcAbstract\rpcMethod;
// Exception
use Oploshka\RpcException\RpcException;
use Oploshka\RpcException\RpcMethodEndException;
// Interface
use Oploshka\RpcContract\iRpcMethod;
use Oploshka\RpcContract\iRpcMethodRequest;
use Oploshka\RpcContract\iRpcMethodStorage;
use Oploshka\RpcContract\iRpcLoadRequest;
use Oploshka\RpcContract\iRpcRequest;
use Oploshka\RpcContract\iRpcResponse;
use Oploshka\RpcContract\iRpcUnloadResponse;

// use Oploshka\RpcException\ReformException; // TODO: fix

class RpcCore {
  
  protected Reform              $reform;              // валидация данных
  protected iRpcMethodStorage   $rpcMethodStorage;    // хранилище методов
  protected iRpcLoadRequest     $rpcLoadRequest;      // обработка данных запроса
  protected iRpcUnloadResponse  $rpcUnloadResponse;   // обработка данных ответа
  
  // // getters
  // public function getReform()               { return $this->reform;               }
  public function getRpcMethodStorage()     { return $this->rpcMethodStorage;     }
  // public function getRpcRequestLoad()       { return $this->rpcRequestLoad;       }
  
  // // setters TODO: fix
  // public function setReform($obj)               { return $this->reform           = $obj; }
  // public function setRpcMethodStorage($obj)     { return $this->rpcMethodStorage = $obj; }
  
  
  public function __construct(array $obj = []) {
    // $this->reform               = $obj['Reform']                ?? new ReformDebug();
    $this->rpcMethodStorage     = $obj['RpcMethodStorage']      ?? new RpcMethodStorage();
  }
  
  
  /**
   * Загружаем данные из запроса. Все возможные ошибки конвертируем к единому исключению
   * @return iRpcRequest
   * @throws RpcException
   */
  public function rpcRequestLoad() :iRpcRequest {
    try {
      // получаем данные из запроса
      $rpcRequest = $this->rpcLoadRequest->load();
    } catch (\Throwable $e) {
      // TODO: fix $e->getMessage() or add function create RpcException
      throw new RpcException('ERROR_REQUEST_LOAD');
    }
    return $rpcRequest;
  }
  
  
  /**
   * @return string Rpc method class name
   * @throws RpcException
   */
  public function getRpcMethodClassName(string $methodName){
    // get method info
    $methodInfo = $this->rpcMethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      throw new RpcException('ERROR_NO_METHOD');
    }
    // method class create
    $methodClassName = $methodInfo['class'];
    //
    $interfaces = class_implements( $methodClassName );
    if ( !isset( $interfaces['Oploshka\RpcContract\iRpcMethod'] ) ) {
      throw new RpcException('ERROR_NOT_INSTANCEOF_INTERFACE');
    }
  
    return $methodClassName;
  }
  
  
  /**
   * @param string $methodName
   * @param array $methodData
   * @throws \ReflectionException TODO: fix ReflectionException -> RpcException
   * @throws RpcException
   */
  public function createRpcMethodClass(string $rpcMethodName, array $rpcMethodData) :iRpcMethod {
    $rpcMethodClassName = $this->getRpcMethodClassName($rpcMethodName);
    
    // TODO: fix validate method data and add exception
    ///# $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClassName::requestSchema()] );
    $data = $rpcMethodData;
    
    // if($data === null) {
    //   $field = [];
    //   $errorObjList = $this->Reform->getError();
    //   foreach ($errorObjList as $errorObj){
    //     $field[] = $errorObj['data'];
    //   }
    //   $rpcResponse->setErrorCode('ERROR_NOT_VALIDATE_DATA')
    //       ->setErrorMessage('')
    //       ->setErrorData(['field' => $field]);
    //   return $rpcResponse;
    // }
  
    $reflectionPropertyData = new \ReflectionProperty($rpcMethodClassName, 'Data');   // Получаем объект ReflectionProperty
    $DataClassName          = $reflectionPropertyData->getType()->getName();      // Получаем имя класса
    /**
     * @var $rpcMethodDataClass iRpcMethodRequest
     */
    $rpcMethodDataClass        = new $DataClassName($data);
    /**
     * @var $rpcMethodClass iRpcMethod
     */
    $rpcMethodClass            = new $rpcMethodClassName();
    $rpcMethodClass->setRpcMethodDataObj($rpcMethodDataClass);
  
    // TODO: add validate
    // TODO: add DI
    
    return $rpcMethodClass;
  }
  
  
  /**
   * Запускаем метод по имени
   * Все ошибки должны быть преобразованы в RpcResponse
   *
   * @param string $rpcMethodName
   * @param array $rpcMethodData
   * @return iRpcResponse
   */
  protected final function runRpcMethod(string $rpcMethodName, array $rpcMethodData) :iRpcResponse {
    ob_start();
    // ErrorHandler::add();
    $rpcResponse = null;
    try {
      $rpcMethod = $this->createRpcMethodClass($rpcMethodName, $rpcMethodData);
      $rpcMethod->run();
      $rpcResponse = $rpcMethod->getRpcMethodResponseObj();
    } catch (\Oploshka\RpcException\RpcMethodEndException $e) {
      // вызвано $Response->error() - завершение метода, обработка ошибок не нужна
      $rpcResponse = $rpcMethod->getRpcMethodResponseObj(); // WARNING - $rpcMethod может не быть...
    // TODO: fix validation error
    // } catch (ReformException $e) {
    //   // Ошибка при валидации
    //   $rpcResponse = new RpcResponse();
    //   $rpcResponse->setErrorCode($e->getMessage());
    } catch (\Throwable $e ) {
      // Прочие ошибки
      $rpcResponse = new RpcResponse();
      $rpcResponse->setErrorCode('ERROR_METHOD_RUN');
      $rpcResponse->setErrorMessage($e->getMessage());
      $rpcResponse->setErrorData([
          'rpcMethodName' => $rpcMethodName,
          'rpcMethodData' => $rpcMethodData,
          'code' => $e->getCode(),
          'line' => $e->getLine(),
      ]);
    }
  
    $echo = ob_get_contents();
  
    // TODO: fix
    // if($echo !== ''){
    //   $this->Logger->warning('echo', $echo );
    // }
  
    // ErrorHandler::remove();
    ob_end_clean();
    
    return $rpcResponse;
  }
  
}
