<?php

namespace Oploshka\Rpc;

use Oploshka\RpcException\RpcException;
use Oploshka\RpcInterface\MethodStorage;

class RpcAutodoc {
  
  /**
   * @param MethodStorage $MethodStorage
   * @return array
   */
  public function docs($MethodStorage) {
    // TODO: fix
    $Rpc = new Rpc();
    $Rpc->setRpcMethodStorage($MethodStorage);
    
    $docs = '';
    $methodList = [ 'UserAuth', 'UserRegistration' ]; // TODO: $MethodStorage->getMethodList();
  
    
    foreach ($methodList as $methodName) {
      $MethodClassName = $Rpc->getMethodClassNameForMethodName($methodName);
      
      $MethodClass = new $MethodClassName( [
        'response'  => false,
        'data'      => false,
        'logger'    => false,
      ] );
  
      $docs .= $this->render($methodName, $MethodClass);
    }
    
    return $docs;
  }
  
  public function render($methodName, $MethodClass){
    $description        = $MethodClass::description();
    $requestSchema      = $MethodClass::requestShema();
    $responseSchema     = $MethodClass::responseSchema();
    
    return <<<HTML
<br><br>
<h4>{$methodName}</h4>
<table style="width:100%;">
  <tr>
    <td style="width:50%; border: 1px solid black; padding: 10px; vertical-align: top;">Запрос на сервер</td>
    <td style="width:50%; border: 1px solid black; padding: 10px; vertical-align: top;">Ответ</td>
  </tr>
  <tr>
    <td style="width: 50%; border: 1px solid black; padding: 10px; text-align: left; vertical-align: top; font-family: Menlo, Monaco, Consolas; font-size: 13px; word-break: break-all;  word-wrap: break-word;">
      {$this->render($requestSchema)}
    </td>
    <td style="width: 50%; border: 1px solid black; padding: 10px; text-align: left; vertical-align: top; font-family: Menlo, Monaco, Consolas; font-size: 13px; word-break: break-all;  word-wrap: break-word;">
      {$this->render($responseSchema)}
    </td>
  <tr>
    <td colspan="2" style="width:100%; border: 1px solid black; padding: 10px; vertical-align: top;">
      <pre style="border: 0px; background: none; padding: 0px; margin: 0px;">{$description}</pre>
    </td>
  </tr>
<table>
HTML;
  }
  
  public function renderSchema($schema){
    return <<<HTML
{
<br>
<div style="margin-left:10px; overflow-x: auto; white-space: pre-wrap;white-space: -moz-pre-wrap !important;white-space: -pre-wrap;white-space: -o-pre-wrap;word-wrap: break-word;">
{$this->renderSchemaList($schema)}
</div>
}
<br>
HTML;
  }
  
  public function renderSchemaList($schema){
    $html = '';
    foreach($schema as $key => $value){
      $html .= $this->renderValue($key, $value);
    }
    return $html;
  }
  
  public function renderValue($key, $validate){
    // require
    $req = '';
    if( isset($validate['req']) && $validate['req']===false ) {
      $req = '<span style="color:red;font-weight:bold">*</span>';
    }
    // type
    return "\"{$req}{$key}\" : \"{$validate['type']}\"<br>";
  }
  
  
}
