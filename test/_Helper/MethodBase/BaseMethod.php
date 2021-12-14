<?php

namespace Oploshka\RpcTestHelper\MethodBase;

use Oploshka\RpcTestHelper\Method\Base\BaseMethodRequest;

class BaseMethod extends \Oploshka\RpcAbstract\iRpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  // Todo: protected | private | public
  protected ?BaseMethodRequest $Data = null;
  
  // TODO: add
  // protected ?BaseMethodResponse $Response;
  
  public function run(){
    $log = $this->Data->getLogin();
    $pas = $this->Data->getPassword();

    $this->setData('login'   , $log);
    $this->setData('password', $pas);
  }
}
