<?php declare(strict_types=1);

namespace Oploshka\RpcTest;

use PHPUnit\Framework\TestCase;

use Oploshka\RpcTestHelper\MethodBase\BaseMethod;
use Oploshka\RpcTestHelper\MethodBase\BaseMethodRequest;

class RpcMethodClassTest extends TestCase {
  
  public function testBaseReturnData() {
    $RpcMethod = new BaseMethod();
    $data = $RpcMethod->getDataObj();
    $this->assertEquals($data,  'ERROR_NO');
  }
  
}
