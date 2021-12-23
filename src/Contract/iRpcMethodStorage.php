<?php

namespace Oploshka\RpcContract;

interface iRpcMethodStorage {
  // public function add($methodName, ....);
  public function getMethodInfo(string $methodName) :?array;
}
