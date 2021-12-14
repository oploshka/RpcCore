<?php

namespace Oploshka\RpcInterface;

interface iRpcMethodStorage {
  // public function add($methodName, ....);
  public function getMethodInfo(string $methodName) :?array;
}
