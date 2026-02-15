$(document).ready(function() {

  $('#box_btnlgin').on('click', '#btnlgin', function(event) {
    event.preventDefault();

    var coduser = $('#coduser').val().trim();
    var pword   = $('#pword').val().trim();

    if (coduser === '' || pword === '') {
      alert('Ingrese usuario y contraseña');
      return;
    }

    $.ajax({
      type: "POST",
      url: '/ajaxjs/lgin/lgin.php',
      data: { coduser: coduser, pword: pword },
      dataType: 'json',
      success: function(response) {

        if (response.sttus) {
          // 👉 SIEMPRE AL INDEX
          window.location.href = '/Comsitec/index.php';
        } else {
          alert(response.msge || 'El usuario o contraseña es incorrecto.');
        }

      },
      error: function(xhr) {
        console.log('STATUS:', xhr.status);
        console.log('RESPONSE:', xhr.responseText);
        alert('Error de servidor');
      }
    });
  });

  $('#coduser, #pword').on('keyup', function(event) {
    if (event.keyCode === 13) {
      $('#btnlgin').click();
    }
  });

});
