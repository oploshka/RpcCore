<?php

namespace Oploshka\RpcMethods;

class SystemMultiple extends \Oploshka\Rpc\Method {

  public static function description(){
    return <<<DESCRIPTION
DESCRIPTION;
  }

  public static function requestSchema(){
    return [];
  }

  // TODO: реализовать...
  public function run(){
  
    /*

    if( $requestInfo['request']['name'] !== 'multiple' ){

      $methodList[] = [
        'method'  => $requestInfo['request']['name'],
        'params'  => $requestInfo['request']['data']
      ];
      return 'ERROR_NO';
    }

    
    $requestType = 'multiple';
  
    if(
      !isset($loadData['request']['data']['multiple'])
      || !is_array($loadData['request']['data'])
      || count($requestInfo['request']['data']['multiple']) === 0
    ) {
      // TODO: use throw new \Exception();
      return 'ERROR_EMPTY_MULTIPLE_REQUEST';
    }
  
    $len = 0;
    foreach ($requestInfo['request']['data']['multiple'] as $key => $request){
      if($len !== $key) { return 'ERROR_NOT_CORRECT_MULTIPLE_ARRAY';}
      $len++;
      // TODO: add validate and error
      $methodList[] = [
        'method' => isset($request['name']) ? $request['name'] : null,
        'params' => isset($request['data']) ? $request['data'] : [],
      ];
    }
    */
    
    /*
    
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

     *
     * */
    
    
    
    $this->Response->error('ERROR_NO');
  }

  public static function responseSchema(){
    return [];
  }
}
