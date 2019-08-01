<?php

namespace Oploshka\Rpc;

class ErrorHandler {

  private static $oldErrorHandler = false;
  private static $errorInfo = [];

  public static function add() {
    if(self::$oldErrorHandler){ return; }
    self::$oldErrorHandler = true;
    set_error_handler( function ($errNo, $errStr, $errFile, $errLine){
      print_r(array(
        'errNo' => $errNo,
        'errStr' => $errStr,
        'errFile' => $errFile,
        'errLine' => $errLine,
      ));
      return true;
    });

    // Перехват вывода на экран
    // ob_start(['\Oploshka\Rpc\ErrorHandler', 'ErrorCallback']);
  }
  public static function remove() {
    if(!self::$oldErrorHandler){ return; }
    self::$oldErrorHandler = false;
    restore_error_handler();
  }

  public static function getErrorInfo() {
    return self::$errorInfo;
  }

  public static function ErrorCallback($buffer) {

    //
    // TODO: register_shutdown_function
    //if (
    //  preg_match("(\nFatal error:)", $buffer, $regs)
    //  ||
    //  preg_match("<br \/>", $buffer, $regs)
    //) {
    //  // ob_end_clean();
    //  // ob_end_clean();
    /* $regs[0] = date("Y-m-d H:i:s (T)")."\n".preg_replace("/<[/]?b(r /)?>/","",$regs[0])."\n"; */
    //  //error_log($regs[0], 3, dirname(__FILE__) . "/log/error.log") or die("Ошибка записи сообщения об ошибке в файл");
    //  return "Ошибка, выполнение прервано";
    //}
    //else

    return $buffer;
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