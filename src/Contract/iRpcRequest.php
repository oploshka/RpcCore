<?php

namespace Oploshka\RpcContract;

interface iRpcRequest {
  
  public function getRequestId();
  public function getMethodName() :string;
  public function getData() :array;
  public function getLanguage() :string;
  public function getVersion() :string;
  
}
