<?php

namespace Oploshka\Rpc;

// TODO
interface iResponse {
  public function getData();
  public function getLog();
  public function getError();
  
  public function setData($key, $value);
  public function setLog($key, $value);
  public function setError($name);
  public function error($name);
  // public function getResponse();
}