<?php

namespace Oploshka\Rpc;

use Oploshka\RpcException\RpcException;

class Rpc extends RpcCore {
  
  /**
   * @param $obj array
   */
  public function __construct($obj = []) {
    parent::__construct($obj);
  }
  
  public function startProcessingRequest($print = true) {
    $MethodResponse = $this->runMethodByRequest();
    return $this->convertMethodResponseToString($MethodResponse);
  }
  
  
  
  /**
   * @return RpcMethodResponse
   */
  public function runMethodByRequest() {
    $Response = false;
    try {
      // получаем данные из запроса
      $RpcMethodRequest = $this->getRpcMethodRequestByRequest();
    } catch (RpcException $e) {
      $Response = new \Oploshka\Rpc\RpcMethodResponse();
      $Response->setErrorCode($e->getMessage());
    } catch (\Throwable $e) {
      /** @var RpcMethodResponse $Response */
      $Response = new \Oploshka\Rpc\RpcMethodResponse();
      $Response->setErrorCode('ERROR_RUN_METHOD_BY_REQUEST');
      $Response->setErrorMessage($e->getMessage());
    }
    
    if($Response) {
      return $Response;
    }
    
    // запустим метод
    $Response = $this->runMethod($RpcMethodRequest);
    
    return $Response;
  }
  
  /**
   * получить запрос
   *
   * @throws RpcException
   * @return RpcMethodRequest
   */
  public function getRpcMethodRequestByRequest() {
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
   * @param $MethodResponse
   * @return mixed
   */
  public function convertMethodResponseToString($RpcRequest, $RpcResponse, $print = false) {
    try {
      $res = $this->_convertMethodResponseToString($RpcRequest, $RpcResponse, $print = false);
    } catch (\Throwable $e) {
      $MethodResponse = new \Oploshka\Rpc\RpcMethodResponse();
      $MethodResponse->setErrorCode('ERROR_RESPONSE_CONVERT');
      $res = $this->_convertMethodResponseToString($RpcRequest, $RpcResponse, $print = false);
    }
    return $res;
  }
  private function _convertMethodResponseToString($RpcRequest, $RpcResponse, $print = false) {
    // создаем структуру
    $responseObject = $this->RpcResponseStructure->encode($RpcResponse, $RpcRequest);
    
    if($print) {
      return $this->RpcResponseFormatter->print($responseObject);
    } else {
      return $this->RpcResponseFormatter->encode($responseObject);
    }
  }
  
  /**
   * Run Rpc method
   * @param RpcMethodRequest     $RpcMethodInfoObj
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
      $Response = new \Oploshka\Rpc\RpcMethodResponse();
    
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
   * @param RpcMethodRequest     $RpcMethodInfoObj
   *
   * @return RpcMethodResponse
   **/
  private function runMethodProcessing($RpcMethodInfoObj) {
  
  
    try {
      /** @var RpcMethodResponse $Response  */
      $Response = new \Oploshka\Rpc\RpcMethodResponse();
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
      $Response = new \Oploshka\Rpc\RpcMethodResponse();
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
  
  /**
   * @param string $methodName
   * @return string Rpc method class name
   */
  public function getMethodClassNameForMethodName($methodName){
    // get method info
    $methodInfo = $this->RpcMethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      throw new RpcException('ERROR_NO_METHOD');
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
