<?php


namespace Oploshka\Rpc;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 */
class Logger extends AbstractLogger implements LoggerInterface
{

  private $logInfo = [];
  public function getLog(){
    return $this->logInfo;
  }

  /**
   * @inheritdoc
   */
  public function log($level, $message, array $context = []) {
    if
    if( !isset( $this->logInfo[$level] ) ){
      $this->logInfo[$level] = [];
    }
    $this->logInfo[$level][] = ['code' => $message, 'data' => $context];
  }
}