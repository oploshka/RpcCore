<?php

namespace Oploshka\RpcCore;

class Core {
  
  /*
   * Run method
   */
  public static function run($_data) {
  
    ob_start();
    
    try {
      $log = '';
      // выводим все ошибки !!!
      ini_set('error_reporting'       , E_ALL);
      ini_set('display_errors'        , 1);
      ini_set('display_startup_errors', 1);
      
      // часовой пояс по умолчанию
      date_default_timezone_set('UTC');
      
      // начальная инициализация
      $response  = new Response(); // переменная для данных ответа
  
      require_once(__DIR__ .'/../conf/method.php');
      /*
      spl_autoload_register(function ($class_name) {
        $url = 'class/method/'.$class_name . '.method.inc';
        if(file_exists($url)) {
          require_once($url);
        } else {
          throw new \Exception("not autoload $url.");
        }
      });
      */
      
      try {
        // Сохраняем название метода
  
        // проверим наличие метода в запросе
        if( !isset($_data['method']) || !is_string($_data['method']) ) {
          $response->error('ERROR_NOT_CORRECT_METHOD_NAME');
        }
        $methodName = $_data['method'];
        
        // получаем описание метода
        $methodInfo = MethodStorage::getMethodInfo($methodName); // self::getMethodInfo();
        if(!$methodInfo) { $response->error('ERROR_NOT_CORRECT_METHOD_INFO'); }
        
        // Доверяем тому что достали из RPCMethodStorage
        // if(!isset($methodInfo['class']) ) { $response->error('ERROR_NOT_CORRECT_CONTROLLER'); }
        $className = $methodInfo['class'];
        $g = '\\';
        if( $methodInfo['group'] != ''  ){
          $g = '\\'.str_replace('/', '\\', $methodInfo['group']). '\\';
        }
        
        $fullClassName = '\RpcMethod' . $g . $methodName;
        // // echo __DIR__;
        // require_once(__DIR__ .'/../method'.$g.$methodName . '.php');
        //
        // if( !class_exists ( $className ) )  {
        //   $response->logAdd('$className = '.$className );
        //   $response->error('ERROR_NOT_CLASS_REALIZATION');
        // }

        $MethodClass = new $fullClassName();

        // проверим реализует ли класс наш интерфейс
        if ( !($MethodClass instanceof MethodInterface) ) {
          $response->error('ERROR_NOT_INSTANCEOF_INTERFACE');
        }
  
        // валидация данных
        $validateDate =  $MethodClass->validate();
        $data = Validate::item($_data, ['type' => 'array', 'validate' => $validateDate] );
        if($data === NULL) {
          $response->error('ERROR_NOT_VALIDATE_DATA');
        }
        $MethodClass->run($response, $data);

      } catch (\Exception $e) {
        $log = $e->getMessage();
      }

      // проверим что метод не убил класс ответа
      if( gettype ( $response ) != 'object' || get_class ( $response ) != 'Rpc\Utils\Response'){
        // Класс убил наш ответ, реанимируем его
        $_response = $response;
        $response = new Response();
        // запишем инфу в логи для дебага
        $response->logAdd( 'gettype = ('   . gettype( $_response )   . ');' );
        if( gettype ( $response ) == 'object' ) {
          $response->logAdd( 'get_class = (' . get_class( $_response ) . ');' );
        }
        $response->error('ERROR_NOT_CORRECT_METHOD_RETURN');
      }
      //
      $response->logAdd( $log );
      // Можно добавить откат всех транзакций в БД при наличии ошибок в запросе

    } catch (\Exception $e) {
      $response->logAdd( $e->getMessage() );
    } // finally {} // php5.5+
  
    // перехвать вывода текста
    $obText = ob_get_contents();
    ob_end_clean();
    if($obText != ''){
      $response->logAdd( $obText );
    }
    
    return $response;
  }

  
  public static function responseToJson($response){
  
    $returnJson = '';
  
    try {
      
      $returnJson = \json_encode(
        $response->getResponse(),
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT| JSON_PARTIAL_OUTPUT_ON_ERROR
      // http://php.net/manual/ru/json.constants.php
      );
    
      // обработки будут появлятся не смотря на установку option
      // по крайней мере что без JSON_PARTIAL_OUTPUT_ON_ERROR, что с ним будет json_last_error = 7
      // if (json_last_error() != 0 && json_last_error() != 7) {
      if (empty($returnJson)) {
        $response = new Response();
        try {
          $response->infoAdd('json_last_error', json_last_error());
          $response->error('ERROR_CONVERT_RESPONSE_TO_JSON');
        } catch (\Exception $e) {
          $returnJson = \json_encode(
            $response->getResponse(),
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT| JSON_PARTIAL_OUTPUT_ON_ERROR
          // http://php.net/manual/ru/json.constants.php
          );
        }
      }
    } catch (\Exception $e) {
      $response->logAdd( $e->getMessage() );
    }
    
    return $returnJson;
  }
  
}