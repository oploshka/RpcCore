<?php

namespace Oploshka\RpcCore;

use Oploshka\Reform\Reform;

class Core {
  
  private $MethodStorage;
  private $Reform;
  
  public function __construct() {
    // TODO fix init
    $this->MethodStorage  = new MethodStorage();
    $this->Reform         = new Reform();
  }
  
  
  /*
   * Run method
   *
   * $_data (type: array):
   * - method (type: string, desc: run method name)
   *
   */
  public function run($methodName, $methodData) {
  
    ob_start();
  
    // выводим все ошибки !!!
    ini_set('error_reporting'       , E_ALL);
    ini_set('display_errors'        , 1);
    ini_set('display_startup_errors', 1);
    
    // часовой пояс по умолчанию
    date_default_timezone_set('UTC');
    
    // начальная инициализация
    $response  = new Response(); // переменная для данных ответа
  
    // валидация метода
    if( !is_string($methodName) || $methodName == '') {
      $response->error('ERROR_NOT_CORRECT_METHOD_NAME', false);
      return $response;
    }
    
    // получаем описание метода
    $methodInfo = $this->MethodStorage->getMethodInfo($methodName);
    if(!$methodInfo) {
      $response->error('ERROR_NOT_CORRECT_METHOD_INFO', false);
      return $response;
    }
    
    
    // Формируем класс метода
    // TODO: fix class name
    $g = '\\';
    if( $methodInfo['group'] != ''  ){
      $g = '\\'.str_replace('/', '\\', $methodInfo['group']). '\\';
    }
    $MethodClassName = '\RpcMethod' . $g . $methodName;

    // method class create
    $MethodClass = new $MethodClassName();

    // проверим реализует ли класс наш интерфейс
    if ( !($MethodClass instanceof RpcMethod) ) {
      $response->error('ERROR_NOT_INSTANCEOF_INTERFACE', false);
      return $response;
    }

    // валидация данных
    $data = $this->Reform->item($methodData, ['type' => 'array', 'validate' => $MethodClass->validate()] );
    if($data === NULL) {
      $response->error('ERROR_NOT_VALIDATE_DATA', false);
      return $response;
    }

    $log = '';
    try {
      $MethodClass->run($response, $data);
    } catch (\Exception $e) {
      $log = $e->getMessage();
    }
    if($log !== ''){
      $response->logAdd( $log );
      $log = '';
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
      $response->error('ERROR_NOT_CORRECT_METHOD_RETURN', false);
    }
    
    // Можно добавить откат всех транзакций в БД при наличии ошибок в запросе

    // перехвать вывода текста
    $obText = ob_get_contents();
    ob_end_clean();
    if($obText != ''){
      $response->logAdd( $obText );
    }
    
    return $response;
  }
  
}