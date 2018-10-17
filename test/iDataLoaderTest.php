<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

class iDataLoaderTest extends TestCase {
  
  public function testSuccessDataLoader() {
    $DataLoader = new \Oploshka\RpcTest\TestDataLoader\DataLoaderSuccess();
    $methodName = '';
    $methodData = [];
    $result = $DataLoader->load($methodName, $methodData);
    $this->assertEquals( $result, true);
    $this->assertEquals( $methodName, 'testMethod');
    $this->assertEquals( $methodData,  ['data1' => 'test']);
  }
  public function testErrorDataLoader() {
    $DataLoader = new \Oploshka\RpcTest\TestDataLoader\DataLoaderError();
    $methodName = '';
    $methodData = [];
    $result = $DataLoader->load($methodName, $methodData);
    $this->assertEquals( $result, 'ERROR_DATA_LOAD_NO_REALIZATION');
    $this->assertEquals( $methodName, '');
    $this->assertEquals( $methodData,  []);
  }
}
