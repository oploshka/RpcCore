<?php

namespace Oploshka\Rpc;

// TODO
interface ResponseInterface {
  public function setData();
  public function setLog();
  public function setError();
  public function error();
  public function get();
}