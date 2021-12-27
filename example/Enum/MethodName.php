<?php declare(strict_types=1);

namespace Oploshka\RpcExample\Enum;

interface MethodName {
  
  // Error (for test)
  const ERROR__InterfaceNotRealization    = 'Error::InterfaceNotRealization';
  const ERROR__RunUnknownFunction         = 'Error::RunUnknownFunction';
  
  //
  const SIMPLE__FAKE_AUTH                 = 'Simple::FakeAuth';
  const SIMPLE__RETURN_SIMPLE_DATA        = 'Simple::ReturnSimpleData';
  const SIMPLE__VALIDATE_BASIC_DATE_TYPE  = 'Simple::ValidateBasicDateType';
  
  const SIMPLE__TEST_DI_LOGGER = 'Simple::TestDiLogger';
}
