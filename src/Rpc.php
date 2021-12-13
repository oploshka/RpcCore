<?php

namespace Oploshka\Rpc;

use Oploshka\RpcException\ReformException;

class Rpc extends RpcCore {
  
  /**
   * @param $obj array
   */
  public function __construct($obj = []) {
    parent::__construct($obj);
  }
  
  public function startProcessingRequest($print = true) {
    $RpcResponse = $this->runMethodByRequest();
    return $this->convertRpcResponseToString($RpcResponse, $print);
  }
  
  /**
   * @return RpcResponse
   */
  public function runMethodByRpcRequest($RpcRequest) {
    return $this->_runMethod($RpcRequest);
  }
  
  /**
   * @return RpcResponse
   */
  public function runMethodByRequest() {
    $Response = false;
    try {
      // получаем данные из запроса
      $RpcRequest = $this->getRpcRequest();
    } catch (ReformException $e) {
      $Response = new \Oploshka\Rpc\RpcResponse();
      $Response->setErrorCode($e->getMessage());
    } catch (\Throwable $e) {
      $Response = new \Oploshka\Rpc\RpcResponse();
      $Response->setErrorCode('ERROR_RUN_METHOD_BY_REQUEST');
      $Response->setErrorMessage($e->getMessage());
    }
    
    if($Response) {
      return $Response;
    }
    
    return $this->runMethodByRpcRequest($RpcRequest);
  }
  
  /**
   * получить запрос
   *
   * @return RpcRequest
   * @throws ReformException
   */
  public function getRpcRequest() {
    // получим данные
    $loadStr = $this->RpcRequestLoad->load();
    // расшифруем
    $loadData = $this->RpcRequestFormatter->decode($loadStr);
    // считываем структуру
    $RpcMethodRequest = $this->RpcRequestStructure->decode($loadData);
    //
    return $RpcMethodRequest;
  }
  
  /**
   * @param $RpcResponse
   * @return mixed
   */
  public function convertRpcResponseToString($RpcResponse, $print = false) {
    try {
      $res = $this->_convertRpcResponseToString($RpcResponse, $print);
    } catch (\Throwable $e) {
      $RpcResponse = new \Oploshka\Rpc\RpcResponse();
      $RpcResponse->setErrorCode('ERROR_RESPONSE_CONVERT');
      $res = $this->_convertRpcResponseToString($RpcResponse, $print);
    }
    return $res;
  }
  private function _convertRpcResponseToString($RpcResponse, $print) {
    // создаем структуру
    $responseObject = $this->RpcResponseStructure->encode($RpcResponse);
    
    if($print) {
      return $this->RpcResponseFormatter->print($responseObject);
    } else {
      return $this->RpcResponseFormatter->encode($responseObject);
    }
  }
  
  /**
   * Run Rpc method
   * @param RpcRequest $RpcRequest
   * @return RpcResponse
   **/
  private function _runMethod($RpcRequest) {
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
    if ( !isset( $interfaces['Oploshka\RpcInterface\Method'] ) ) {
      throw new \RpcException('ERROR_NOT_INSTANCEOF_INTERFACE');
    }
    
    return $MethodClassName;
  }
  
}
