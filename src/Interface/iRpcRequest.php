<?php

namespace Oploshka\RpcInterface;

interface iRpcRequest {
  
  public function getRequestId();
  public function getMethodName() :string;
  public function getData() :array;
  public function getLanguage() :string;
  public function getVersion() :string;
  
}
