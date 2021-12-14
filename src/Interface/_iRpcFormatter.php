<?php

namespace Oploshka\RpcInterface;

/*
 * Интерфейс для преобразования тела запроса в объект и обратно
 * например: json/xml/csv <-> object
 *
 **/
interface iRpcFormatter {
  public function decode($str);
  public function encode($obj);
  public function print($obj);
}
