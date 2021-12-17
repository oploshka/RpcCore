<?php

namespace Oploshka\RpcTestHelper\MethodBase;

class MethodBase extends \Oploshka\RpcAbstract\RpcMethod {
  
  public static function description(): string {
    return '';
  }
  
  // Todo: protected | private | public
  protected ?MethodBaseRequest $Data = null;
  
  // TODO: add
  // protected ?BaseMethodResponse $Response;
  
  public function run(){
    $log = $this->Data->getLogin();
    $pas = $this->Data->getPassword();

    $this->setData('login'   , $log);
    $this->setData('password', $pas);
  }
}
