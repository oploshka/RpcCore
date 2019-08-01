<?php

namespace Oploshka\Rpc;

class ErrorHandler {
  
  private static $oldErrorHandler = false;
  private static $errorInfo = [];
  
  public static function add() {
    if(self::$oldErrorHandler){ return; }
    self::$oldErrorHandler = true;
    set_error_handler( ['Oploshka\Rpc\ErrorHandler', 'ErrorHandlerFunction'],E_ALL);
  }
  public static function remove() {
    if(!self::$oldErrorHandler){ return; }
    self::$oldErrorHandler = false;
    restore_error_handler();
  }

  public static function getErrorInfo() {
    return self::$errorInfo;
  }

  public static function ErrorHandlerFunction($errNo, $errStr, $errFile, $errLine) {

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

    return true;
  }
  

  
}