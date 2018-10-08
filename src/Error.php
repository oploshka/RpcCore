<?php

namespace Oploshka\RpcCore;

class Error {
  
  private static $errorInfo = [];
  
  /**
   * @return array
   */
  public static function getErrorInfo() {
    return self::$errorInfo;
  }
  
  public static function add()     {
    set_error_handler(
      create_function(
        '$c, $m, $f, $l',
        'Rpc\Utils\ErrorHandler::ErrorHandler($m, $c, $f, $l);'
      ),
      E_ALL
    );
    // -set_error_handler(static::ErrorHandler($m, $c, $f, $l), E_ALL);
    // -set_error_handler("static::ErrorHandler", E_ALL);
  }
  
  
  
  
  // функция обработки ошибок
  public static function ErrorHandler($errNo, $errStr, $errFile, $errLine) {
    // if (!(error_reporting() & $errno)) {
    //     // Этот код ошибки не включен в error_reporting
    //     return;
    // }
    
    print_r(array(
      'errNo' => $errNo,
      'errStr' => $errStr,
      'errFile' => $errFile,
      'errLine' => $errLine,
    ));
    
    self::$errorInfo[] = array(
      'errNo' => $errNo,
      'errStr' => $errStr,
      'errFile' => $errFile,
      'errLine' => $errLine,
    );

    // echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
    // echo "  Фатальная ошибка в строке $errline файла $errfile";
    // echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
    // echo "Завершение работы...<br />\n";
    // exit(1);
    
    // switch ($errno) {
    // case E_USER_ERROR:
    //     echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
    //     echo "  Фатальная ошибка в строке $errline файла $errfile";
    //     echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
    //     echo "Завершение работы...<br />\n";
    //     exit(1);
    //     break;
    //
    // case E_USER_WARNING:
    //     echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
    //     break;
    //
    // case E_USER_NOTICE:
    //     echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
    //     break;
    //
    // default:
    //     echo "Неизвестная ошибка: [$errno] $errstr<br />\n";
    //     break;
    // }
    
    /* Не запускаем внутренний обработчик ошибок PHP */
    return true;
  }
  
}