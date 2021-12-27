<?php

namespace Oploshka\RpcContract;

/**
 * Interface iRpcRequestLoad
 * @package Oploshka\RpcContract
 *
 * Данный слой может состоять из 3 подслоев
 * - получение данных (вытаскивание их запроса) и отдаем набор байт или текс
 * - codec vs Cryptography (decode, encode), преобразование из json, xml в объект
 * - RequestStructureLoader - преобразование объекта в класс iRpcRequest
 */
interface iRpcLoadRequest {
  
  public function load() :iRpcRequest;

}

/*

public function load() :iRpcRequest {
  // получим данные
  $loadStr = $this->RpcRequestLoad->load();
  // расшифруем
  $loadData = $this->RpcRequestFormatter->decode($loadStr);
  // считываем структуру
  $RpcMethodRequest = $this->RpcRequestStructure->decode($loadData);
  //
  return $RpcMethodRequest;
}
 */