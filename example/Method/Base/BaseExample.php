<?php

namespace Oploshka\RpcExample\Method\Base;

class BaseExample extends \Oploshka\Rpc\Method\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  // Todo: protected | private | public
  protected ?BaseExampleRequest $Data = null;
  
  // TODO: add
  // protected ?BaseMethodResponse $Response;
  
  public function run(){
    $log = $this->Data->getLogin();
    $pas = $this->Data->getPassword();

    $this->setData('login'   , $log);
    $this->setData('password', $pas);
  }
}
