<?php

namespace Oploshka\Rpc;

// TODO
interface ResponseInterface {
  public function getData();
  public function getLog();
  public function getError();
  
  public function setData($key, $value);
  public function setLog($key, $value);
  public function setError($name);
  public function error($name);
  // public function getResponse();
}