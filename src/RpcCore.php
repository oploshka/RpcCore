<?php

namespace Oploshka\Rpc;

use Oploshka\Reform\Reform;
use Oploshka\Reform\ReformDebug;
use Oploshka\RpcInterface\iRpcMethodStorage;
use Oploshka\RpcInterface\iRpcLoadRequest;
use Oploshka\RpcInterface\iRpcResponse;
use Oploshka\RpcInterface\iRpcUnloadResponse;

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
  
  /**
   * Run Rpc method
   *
   * @param RpcRequest $RpcRequest
   *
   * @return RpcResponse
   **/
  private function _runMethodProcessing($RpcRequest) {
    
    
    try {
      /** @var RpcResponse $Response  */
      $Response = new \Oploshka\Rpc\RpcResponse([
          'RpcRequest' => $RpcRequest,
      ]);
      //
      $methodName = $RpcRequest->getMethodName();
      $methodData = $RpcRequest->getData();
      
      $MethodClassName = $this->getMethodClassNameForMethodName($methodName);
      
      // validate method data
      $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClassName::requestSchema()] );
      if($data === null) {
        $field = [];
        $errorObjList = $this->Reform->getError();
        foreach ($errorObjList as $errorObj){
          $field[] = $errorObj['data'];
        }
        $Response->setErrorCode('ERROR_NOT_VALIDATE_DATA')
            ->setErrorMessage('')
            ->setErrorData(['field' => $field]);
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
    } catch (ReformException $e) {
      $Response->setErrorCode($e->getMessage());
      return $Response;
    }
    catch (\Throwable $e ) {
      $Response = new \Oploshka\Rpc\RpcResponse([
          'RpcRequest' => $RpcRequest,
      ]);
      $Response->setError(
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
    
    return $Response;
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
