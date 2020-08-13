<?php

namespace Oploshka\RpcInterface;

/*
 * Интерфейс для первичного получения данных из запроса
 */
interface RpcRequestLoad {
  
  /*
   * @return object | string
   **/
  public function load();

}
