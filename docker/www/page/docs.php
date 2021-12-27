<!DOCTYPE>
<html>
<head>
  <title>Rpc example</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div style="padding:50px;">
  <?php
    require __DIR__ . '/../vendor/autoload.php';
  
    $rpc = Oploshka\RpcExample\RpcServer::getRpc();
    $rpcMethodStorage = Oploshka\RpcExample\RpcServer::getRpcMethodStorage();
    
    $rpcDoc = new \Oploshka\Rpc\Helper\RpcAutoDoc();

    echo $rpcDoc->docs($rpc, $rpcMethodStorage);
  ?>
</div>

</body>
</html>
