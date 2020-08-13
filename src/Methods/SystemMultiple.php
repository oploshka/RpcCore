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
      // TODO: use throw new Exception();
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
    
    $this->Response->error('ERROR_NO');
  }

  public static function responseSchema(){
    return [];
  }
}
