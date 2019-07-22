<?php

namespace Oploshka\RpcInterface;

interface MethodStorage {
  // public function add($methodName, ....);
  public function getMethodInfo($methodName);
}
