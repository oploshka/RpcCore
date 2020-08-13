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


/**
 * throw exceptions based on E_* error types
 * /
set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
  // error was suppressed with the @-operator
  if (0 === error_reporting()) {
    return false;
  }
  switch ($err_severity) {
    case E_ERROR:
      throw new ErrorException            ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_WARNING:
      throw new WarningException          ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_PARSE:
      throw new ParseException            ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_NOTICE:
      throw new NoticeException           ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_CORE_ERROR:
      throw new CoreErrorException        ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_CORE_WARNING:
      throw new CoreWarningException      ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_COMPILE_ERROR:
      throw new CompileErrorException     ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_COMPILE_WARNING:
      throw new CoreWarningException      ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_USER_ERROR:
      throw new UserErrorException        ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_USER_WARNING:
      throw new UserWarningException      ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_USER_NOTICE:
      throw new UserNoticeException       ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_STRICT:
      throw new StrictException           ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_RECOVERABLE_ERROR:
      throw new RecoverableErrorException ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_DEPRECATED:
      throw new DeprecatedException       ($err_msg, 0, $err_severity, $err_file, $err_line);
    case E_USER_DEPRECATED:
      throw new UserDeprecatedException   ($err_msg, 0, $err_severity, $err_file, $err_line);
  }
});

class WarningException extends ErrorException{}
class ParseException extends ErrorException{}
class NoticeException extends ErrorException{}
class CoreErrorException extends ErrorException{}
class CoreWarningException extends ErrorException{}
class CompileErrorException extends ErrorException{}
class CompileWarningException extends ErrorException{}
class UserErrorException extends ErrorException{}
class UserWarningException extends ErrorException{}
class UserNoticeException extends ErrorException{}
class StrictException extends ErrorException{}
class RecoverableErrorException extends ErrorException{}
class DeprecatedException extends ErrorException{}
class UserDeprecatedException extends ErrorException{}

*/
