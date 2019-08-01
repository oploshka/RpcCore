<?php


namespace Oploshka\Rpc;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class Logger
 */
class Logger extends AbstractLogger implements LoggerInterface
{

  private $logLevel = [
    LogLevel::EMERGENCY => true,
    LogLevel::ALERT     => true,
    LogLevel::CRITICAL  => true,
    LogLevel::ERROR     => true,
    LogLevel::WARNING   => true,
    LogLevel::NOTICE    => true,
    LogLevel::INFO      => true,
    LogLevel::DEBUG     => true,
  ];

  private $logInfo = [];
  public function getLog(){
    return $this->logInfo;
  }

  /**
   * @inheritdoc
   */
  public function log($level, $message, array $context = []) {

    if( !isset($this->logLevel[$level]) ){
      throw new Exception('ERROR_NOT_CORRECT_LOG_LEVEL');
    }

    if( !isset( $this->logInfo[$level] ) ){
      $this->logInfo[$level] = [];
    }
    $this->logInfo[$level][] = ['code' => $message, 'data' => $context];
  }
}