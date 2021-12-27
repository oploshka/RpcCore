<!DOCTYPE>
<html>
<head>
  <title>Rpc example</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div style="padding:50px;">
  <form id="ajax">
    <p><textarea rows="10" cols="45" name="data" class="filead">{
  "specification": "multipart-json-rpc",
  "specificationVersion" : "0.1.0",
  "version": "1",
  "language": "en",
  "request" : {
    "id"   : "9423234",
    "name" : "MethodTest1",
    "data" : { "userId" : 1 }
  }
}</textarea><br>
    <!--
    <p>profileImage
      <input id="profileImage" type="file" name="profileImage" accept="image/x-png,image/gif,image/jpeg"/>
      <button id="profileImage-button">Clear</button>
    </p>
    -->
    
    <input type="submit" value="Отправить"/>
  </form>
  <pre id="load-status"></pre>
  <pre id="json-renderer"></pre>
</div>

<!-- script -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<link rel="stylesheet" href="/js/json-viewer/jquery.json-viewer.css"/>
<script src="/js/json-viewer/jquery.json-viewer.js"></script>

<script src="/js/form.js"></script>
<!-- script -->

</body>
</html>
