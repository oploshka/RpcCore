<?php

namespace Oploshka\Rpc\Plugin\RpcCodec;

class RpcCodecJson {
  
  public function decode(string $str) :array{
    $data = (array) json_decode ($str, true);
    if (json_last_error() != 0){
      // TODO: fix
      throw new \Exception('Decode error');
    }
    return $data;
  }
  
  public function encode($data) :string{
  
    $str = json_encode(
      $data,
      JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT| JSON_PARTIAL_OUTPUT_ON_ERROR
      // http://php.net/manual/ru/json.constants.php
    );
  
    // обработки будут появлятся не смотря на установку option
    // по крайней мере что без JSON_PARTIAL_OUTPUT_ON_ERROR, что с ним будет json_last_error = 7
    // if (json_last_error() != 0 && json_last_error() != 7) {
    if (empty($str)) {
      $err = json_last_error();
      // TODO: fix
      throw new \Exception('Encode error '.$err);
    }
    return $str;
  }
}
