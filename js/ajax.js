$(function() {

  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : urldecode(sParameterName[1]);
      }
    }
  };

  var typingTimer;

  function ajaxTest() {

    $.ajax({
      url:'ajax.php',
      type:'POST',
      dataType: 'json',
      data:{
        message: 'hello',

      },
      success:function(result) {

        console.log(result.changed);

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus); alert("Error: " + errorThrown);
      }

    });


  }




});
