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
    "jsonrpc": "2.0",
    "method": "User::get",
    "params": {
      "userId": 44
    },
    "id": null
  }</textarea><br>
    
    <p>profileImage
      <input id="profileImage" type="file" name="profileImage" accept="image/x-png,image/gif,image/jpeg"/>
      <button id="profileImage-button">Clear</button>
    </p>
    
    <p>conferenceIconImage
      <input id="conferenceIconImage" type="file" name="conferenceIconImage" accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceIconImage-button">Clear</button>
    </p>
    
    <p>conferenceLogoImage
      <input id="conferenceLogoImage" type="file" name="conferenceLogoImage" accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceLogoImage-button">Clear</button>
    </p>
    
    <p>conferenceGalleryImage1
      <input id="conferenceGalleryImage1" type="file" name="conferenceGalleryImage1"
             accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceGalleryImage1-button">Clear</button>
    </p>
    
    <p>conferenceGalleryImage2
      <input id="conferenceGalleryImage2" type="file" name="conferenceGalleryImage2"
             accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceGalleryImage2-button">Clear</button>
    </p>
    
    <p>conferenceGalleryImage3
      <input id="conferenceGalleryImage3" type="file" name="conferenceGalleryImage3"
             accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceGalleryImage3-button">Clear</button>
    </p>
    
    <p>conferenceGalleryImage4
      <input id="conferenceGalleryImage4" type="file" name="conferenceGalleryImage4"
             accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceGalleryImage4-button">Clear</button>
    </p>
    
    <p>conferenceGalleryImage5
      <input id="conferenceGalleryImage5" type="file" name="conferenceGalleryImage5"
             accept="image/x-png,image/gif,image/jpeg"/>
      <button id="conferenceGalleryImage5-button">Clear</button>
    </p>
    
    <input type="submit" value="Отправить"/>
  </form>
  <pre id="load-status"></pre>
  <pre id="json-renderer"></pre>
</div>

<!-- script -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<link rel="stylesheet" href="/js/json-viewer/jquery.json-viewer.css"/>
<script src="/js/json-viewer/jquery.json-viewer.js"></script>

<script src="/js/json-viewer/jquery.json-viewer.js"></script>
<!-- script -->

</body>
</html>
