<?php


namespace Oploshka\Rpc;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 */
class Logger extends AbstractLogger implements LoggerInterface
{

  private $log = [];
  public function getLog(){
    return $this->log;
  }

  /**
   * @inheritdoc
   */
  public function log($level, $message, array $context = []) {
    if( !isset( $this->log[$level] ) ){
      $this->log[$level] = [];
    }
    $this->log[$level][] = ['code' => $message, 'data' => $context];
  }
}