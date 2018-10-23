<?php

namespace Oploshka\Rpc;

use PHPUnit\Framework\TestCase;

class iDataLoaderTest extends TestCase {
  
  public function testSuccessDataLoader() {
    $DataLoader = new \Oploshka\RpcTest\TestDataLoader\DataLoaderSuccess();
    $loadData = [];
    $result = $DataLoader->load($loadData);
    $methodName = $loadData['method'] ?? '';
    $methodData = $loadData['params'] ?? [];
    $this->assertEquals( $result, 'ERROR_NOT');
    $this->assertEquals( $methodName, 'testMethod');
    $this->assertEquals( $methodData,  ['data1' => 'test']);
  }
  public function testErrorDataLoader() {
    $DataLoader = new \Oploshka\RpcTest\TestDataLoader\DataLoaderError();
    $loadData = [];
    $result = $DataLoader->load($loadData);
    $methodName = $loadData['method'] ?? '';
    $methodData = $loadData['params'] ?? [];
    $this->assertEquals( $result, 'ERROR_DATA_LOAD_NO_REALIZATION');
    $this->assertEquals( $methodName, '');
    $this->assertEquals( $methodData,  []);
  }
}
