var uriServiceProvider = "/api";

jQuery( "form#ajax" ).submit(function( event ) {
  jQuery("#load-status").html('loading ...');
  jQuery("#json-renderer").html('');
  event.preventDefault();
  
  var form = document.forms.ajax;
  var formData = new FormData(form);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", uriServiceProvider);
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 ) {
      jQuery("#load-status").html("Ok");
      console.log(xhr);
      
      try {
        var input = eval("(" + xhr["responseText"] + ")");
        jQuery("#json-renderer").jsonViewer( input );
      }
      catch (error) {
        jQuery("#json-renderer").html( xhr["responseText"] );
      }
    }
  };
  xhr.send(formData);
});


//
function fileReset(idName){
  var control = $("#" + idName),
    clearBn = $("#" + idName + "-button");
  
  // Setup the clear functionality
  clearBn.on("click", function(){
    control.replaceWith( control.val('') );
  });
  
  // Some bound handlers to preserve when cloning
  control.on({
    change: function(){ console.log( "Changed" ) },
    focus: function(){ console.log(  "Focus"  ) }
  });
}

fileReset("profileImage")
fileReset("conferenceIconImage")
fileReset("conferenceLogoImage")

fileReset("conferenceGalleryImage1")
fileReset("conferenceGalleryImage2")
fileReset("conferenceGalleryImage3")
fileReset("conferenceGalleryImage4")
fileReset("conferenceGalleryImage5")