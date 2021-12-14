<?php

namespace Oploshka\RpcInterface;

/*
 * Интерфейс для преобразования тела запроса в объект и обратно
 * например: json/xml/csv <-> object
 *
 **/
interface iRpcEncode {
  public function decode($str);
  public function encode($obj);
}
