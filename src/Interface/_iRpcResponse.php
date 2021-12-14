<?php

namespace Oploshka\RpcInterface;

interface iRpcResponse {
  public function getData();
  public function setData($key, $value);

  public function getError();
  public function setError($name);
  public function error($name);
}