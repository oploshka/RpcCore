<?php

namespace Oploshka\RpcInterface;

/*
 * Интерфейс для преобразования тела запроса в объект и обратно
 * например: json/xml/csv <-> object
 *
 **/
interface RpcFormatter {
  public function decode($str);
  public function encode($obj);
  public function print($obj);
}
