RpcCore
=================

* [1.Installation](#block1)
* [2. Features](#block2)
* [3. Usage](#block3)
* [4. Code Quality](#block5)
* [5. Author](#block6)
* [6. Special Thanks](#block6)
* [7. License](#block7)

<a name="block1"></a>
## 1.Installation
The recommended way to install is through [Composer](http://getcomposer.org). Run the following command to install it:

```sh
php composer.phar require oploshka/rpc-core
```

<a name="block2"></a>
## 2. Features

**Simplicity**
- simple implementations are available out of the box.

**Scalability**
- Ability to write your own processing.
- Possibility to combine your own and built-in solutions
- Possibility of step-by-step override.

<a name="block3"></a>
## 3. Usage

Sample code:
```php
$MethodStorage  = new \Oploshka\Rpc\MethodStorage();

$MethodStorage->add('TestMethod1', '\\RpcMethodPath\\TestMethod1');
$MethodStorage->add('TestMethod2', '\\RpcMethodPath\\TestMethod2');

// init MultipartJsonRpc_v0_1
$rpcInitData = [
  'methodStorage'   => $MethodStorage                                           ,
  'reform'          => new \Oploshka\Reform\ReformDebug()                       ,
  'dataLoader'      => new \Oploshka\RpcDataLoader\PostMultipartFieldJson()     ,
  'dataFormatter'   => new \Oploshka\RpcDataFormatter\MultipartJsonRpc_v0_1()   ,
  'returnFormatter' => new \Oploshka\RpcReturnFormatter\MultipartJsonRpc_v0_1() ,
  'responseClass'   => new \Oploshka\Rpc\Response()                             ,
];
$Rpc = new \Oploshka\Rpc\Core($rpcInitData);
$Rpc->applyHeaderSettings();
$Rpc->applyPhpSettings();

$returnJson = $Rpc->startProcessingRequest();

echo $returnJson;
```
More info in docs

<a name="block4"></a>
## 4. Testing
Testing has been done using PHPUnit. Code has been tested to be PHP 7.0.

<a name="block5"></a>
## 5. Author
Andrey Tyurin
 - <ectb08@mail.ru>


<a name="block6"></a>
## 6. Special Thanks
I would like to thank all the people who know me and surround me.

<a name="block7"></a>
## 7. License
"Rpc-core" is licensed under the MIT license.

```
Copyright (c) 2018 Andrey Tyurin

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
```
