var base_url = window.location.protocol + '//' + window.location.host + window.location.pathname.replace(/\/[^\/]*$/, '/');

$(document).ready(function() {
  $('#box_btnlgin').on('click', '#btnlgin', function() {
    event.preventDefault();
    var coduser = $('#coduser').val();
    var pword = $('#pword').val();
    $.ajax({
      type: "POST",
      url: 'ajaxjs/ajax_lgin.php',
      data: { coduser: coduser, pword: pword },
      dataType: 'json',
      success: function(response) {
        if(response.sttus){
          window.location.href = base_url;
        }
        else{
          alert(response.msge);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $('#coduser, #pword').on('keyup', function(event) {
    if (event.keyCode === 13) {
      $('#btnlgin').click();
    }
  });
});