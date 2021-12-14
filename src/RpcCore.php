<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\Reform;
use Oploshka\Reform\ReformDebug;
use Oploshka\RpcInterface\iRpcMethodStorage;
use Oploshka\RpcInterface\iRpcLoadRequest;
use Oploshka\RpcInterface\iRpcRequest;
use Oploshka\RpcInterface\iRpcResponse;
use Oploshka\RpcInterface\iRpcUnloadResponse;

use Oploshka\RpcException\ReformException; // TODO: fix

class RpcCore {
  
  protected Reform              $reform;              // валидация данных
  protected iRpcMethodStorage   $rpcMethodStorage;    // хранилище методов
  protected iRpcLoadRequest     $rpcLoadRequest;      // обработка данных запроса/ответа
  protected iRpcUnloadResponse  $rpcUnloadResponse;
  


  public function __construct(array $obj = []) {
    $this->reform               = $obj['Reform']                ?? new ReformDebug();
    $this->rpcMethodStorage     = $obj['RpcMethodStorage']      ?? new RpcMethodStorage();
  }
  
  // // getters
  // public function getReform()               { return $this->Reform;               }
  // public function getRpcMethodStorage()     { return $this->RpcMethodStorage;     }
  // public function getRpcRequestLoad()       { return $this->RpcRequestLoad;       }
  
  // // setters TODO: fix
  // public function setReform($obj)               { return $this->Reform           = $obj; }
  // public function setRpcMethodStorage($obj)     { return $this->RpcMethodStorage = $obj; }
  
  
  public function startProcessingRequest($print = true) {
    $RpcResponse = $this->runMethodByRequest();
    return $this->convertRpcResponseToString($RpcResponse, $print);
  }
  
  
  public function runMethodByRequest() :iRpcResponse {
    $errorResponse = null;
    try {
      // получаем данные из запроса
      $RpcRequest = $this->rpcLoadRequest->load();
    } catch (ReformException $e) { // TODO: fix
      $errorResponse = new RpcResponse();
      $errorResponse->setErrorCode($e->getMessage());
    } catch (\Throwable $e) {
      $errorResponse = new RpcResponse();
      $errorResponse->setErrorCode('ERROR_RUN_METHOD_BY_REQUEST');
      $errorResponse->setErrorMessage($e->getMessage());
    }
    
    if($errorResponse) {
      return $errorResponse;
    }
    
    return $this->runMethodByRpcRequest($RpcRequest);
  }
  
  
  public function runMethodByRpcRequest($RpcRequest) :iRpcResponse  {
    ob_start();
    // ErrorHandler::add();
    
    // это нужно для корректного закрытия ob_start
    $Response = $this->_runMethodProcessing($RpcRequest);
    
    // проверим что в ответе не шляпа а RpcResponse
    if( !$this->isResponse($Response)) {
      $responseLink = $Response;
      
      /** @var RpcResponse  */
      $Response = new \Oploshka\Rpc\RpcResponse();
      
      $errorData = [
          'gettype' => gettype($responseLink)
      ];
      if( gettype ( $responseLink ) == 'object' ) {
        $errorData['get_class'] = get_class($responseLink);
      }
      
      $Response->setError(
          new RpcError([
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
  

  private function _runMethodProcessing(iRpcRequest $rpcRequest) :iRpcResponse {
    
    
    try {
      $rpcResponse = new RpcResponse();
      //
      $methodName = $rpcRequest->getMethodName();
      $methodData = $rpcRequest->getData();
      
      $MethodClassName = $this->getMethodClassNameForMethodName($methodName);
      
      // validate method data
      $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClassName::requestSchema()] );
      if($data === null) {
        $field = [];
        $errorObjList = $this->Reform->getError();
        foreach ($errorObjList as $errorObj){
          $field[] = $errorObj['data'];
        }
        $rpcResponse->setErrorCode('ERROR_NOT_VALIDATE_DATA')
            ->setErrorMessage('')
            ->setErrorData(['field' => $field]);
        return $rpcResponse;
      }
      
      // TODO: fix and add DI
      $MethodClass = new $MethodClassName( [
          'response'  => $rpcResponse,
          'data'      => $data,
      ] );
      $returnResponse = $MethodClass->run();
      if( $returnResponse !== null && $this->isResponse($returnResponse)) {
        $Response = $returnResponse;
      }
      
    // TODO: fix
    ///#
    ///#} catch (\Oploshka\RpcException\MethodEndException $e) {
    ///#  // вызвано $Response->error() - завершение метода, обработка ошибок не нужна
    } catch (ReformException $e) {
      $rpcResponse->setErrorCode($e->getMessage());
      return $rpcResponse;
    }
    catch (\Throwable $e ) {
      $rpcResponse = new RpcResponse();
      $rpcResponse->setError(
          new RpcError([
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
    
    return $rpcResponse;
  }
  
  // $Response is Response class?
  public function isResponse($Response) {
    $responseType = gettype ( $Response );
    if( $responseType === 'object' && get_class ( $Response ) != 'Oploshka\Rpc\RpcResponse'){
      return false;
    }
    return true;
  }
  
  /**
   * @param string $methodName
   * @return string Rpc method class name
   */
  public function getMethodClassNameForMethodName($methodName){
    // get method info
    $methodInfo = $this->RpcMethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      throw new ReformException('ERROR_NO_METHOD');
    }
    // method class create
    $MethodClassName = $methodInfo['class'];
    //
    $interfaces = class_implements( $MethodClassName );
    if ( !isset( $interfaces['Oploshka\RpcInterface\iRpcMethod'] ) ) {
      throw new \RpcException('ERROR_NOT_INSTANCEOF_INTERFACE');
    }
    
    return $MethodClassName;
  }
  
}
