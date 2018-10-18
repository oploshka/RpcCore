# Data loader examples

### Data loader success example
```php
<?php

namespace example;

class DataLoaderSuccess implements iDataLoader{
  
  public function load(&$methodName, &$methodData){
    $methodName = 'testMethod';
    $methodData = ['data1' => 'test'];
    return true;
  }
  
}
```

### Data loader error example
```php
<?php

namespace example;

class DataLoaderError implements iDataLoader{
  
  public function load(&$methodName, &$methodData){
    return 'ERROR_DATA_LOAD_NO_REALIZATION';
  }
  
}
```