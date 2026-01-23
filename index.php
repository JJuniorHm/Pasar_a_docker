<?php

define("pag_mainslider", 1); define('pag_warranty', 1); define("pag_missingimages", 1);
define("pag_signaturemail", 1); define("pag_body", 1); define("pag_taskmnger", 1); define("pag_errorrcord", 1); define("pag_userprivileges", 1);  define("pag_specifications", 1); define("pag_update_tb_prod", 1);
define("pag_update_tb_prod_zc", 1); define("pag_register_user",1);
require "cfig.php";
include "csses/class_lgin/user.php";


$pag_nme = '';

$user = new user();

if (!empty($_SESSION['ucoduser'])) {
  $coduser = $_SESSION['ucoduser'];
}

if ($user->getSession() === FALSE || empty($coduser)) {
  header("location:".$base_url ."lgn.php");
  exit;
}

if (isset($_GET['q'])) {
  $user->logout();
  header("location:".$base_url ."lgn.php");
  exit;
}

$user->setCodUser($coduser);
$userinfo = $user->getUserInfo();

$btnuserprivileges = "";
include "csses/privileges.php";
$Validate_Privileges = NEW Validate_Privileges();
$Validate_Privileges->setCodUser($userinfo["ucoduser"]);
$checkvp = $Validate_Privileges->validate_privileges_in_userprivileges();
if($checkvp && $checkvp->num_rows == 1){

	if(isset($_GET["p"]) && $_GET["p"] == "pag_userprivileges" ){
		$active = "active";
	}
	else {
		$active = "";
	}

	$btnuserprivileges = '
						<li class="dns_sdbarli '.$active.' ">
							<div class="iocn-link">
								<a href="?p=pag_userprivileges">
									<i class="bx bxs-user-check"></i>
									<span class="dns_btnnme">Privilegios&nbsp;GI</span>
								</a>
							</div>
						</li>';
}
else{
	$btnuserprivileges = "";
}


$btnRegisterUser = "";

$checkRegister = $Validate_Privileges->validate_privileges_in_register_user();
if ($checkRegister && $checkRegister->num_rows == 1) {
    $active = (isset($_GET['p']) && $_GET['p'] == 'pag_register_user') ? 'active' : '';
    $btnRegisterUser = '
        <li class="dns_sdbarli '.$active.'">
            <div class="iocn-link">
                <a href="?p=pag_register_user">
                    <i class="bx bxs-user-plus"></i>
                    <span class="dns_btnnme">Registro de Usuarios</span>
                </a>
            </div>
        </li>';
}
else {
    $btnRegisterUser = "";
}


$pag = isset($_GET['p']) ? strtolower($_GET['p']) : 'pag_body';
$pag_script = '';
switch ($pag) {

  case 'pag_body2':
    $pag = 'pag_body2';
    break;

  case 'pag_taskmnger':
    $pag = 'pag_taskmnger';
    break;

  case 'pag_errorrcord':
    $pag = 'pag_errorrcord';
    break;

  case 'pag_userprivileges':
    $pag = 'pag_userprivileges';
    break;

  case 'pag_signaturemail':
    $pag = 'pag_signaturemail';
    break;

  case 'pag_mainslider':
    $pag = 'pag_mainslider';
    break;

  case 'pag_warranty':
    $pag = 'pag_warranty';
    break;

  case 'pag_specifications':
    $pag = 'pag_specifications';
    break;

  case 'pag_update_tb_prod':
    $pag = 'pag_update_tb_prod';
    break;

  case 'pag_update_tb_prod_zc':
    $pag = 'pag_update_tb_prod_zc';
    break;

  case 'pag_missingimages':
    $pag = 'pag_missingimages';
    break;

  case 'pag_register_user':
    $pag = 'pag_register_user';
    $pag_script = 'assets/js/user/register.js';
    break;

  default:
    $pag = 'pag_body';
    break;
}


?>

<!DOCTYPE html>
<html>
<head>
  <title>DnsDev - Gestor Integral</title>
  <link href="favicon.png" rel="shortcut icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='assets/css/2.1.4_boxicons.min.css' rel='stylesheet'>
  <link href='assets/css/bootstrap.min.css' rel='stylesheet'>
  <link href='assets/css/DNSDev.css' rel='stylesheet'>
  <script src="assets/js/jquery-3.6.4.min.js"></script>

  <script>
    const BASE_URL = "<?php echo $base_url; ?>";
  </script>

  <?php include "assets/css/dnsv1.php"; ?>
</head>

<body>
	<div class="dns_sdbar">
		<ul class="dns_sdbarul">
			<div class="tgesdbr">
				<i id="tggleSdbar" class='bx bxs-chevrons-left'></i>
			</div> 

			<li class="dns_sdbarli <?php echo isset($_GET['p']) && $_GET['p'] == 'pag_body' ? 'active': '' ?>">
				<div class="iocn-link">
					<a href="?p=pag_body">
						<i class='bx bxs-dashboard'></i>
						<span class="dns_btnnme">Inicio</span>
					</a>
				</div>
			</li>

			<?php echo $btnRegisterUser; ?>

			<?php echo $btnuserprivileges; ?>

			<li class="dns_sdbarli <?php echo isset($_GET['p']) && $_GET['p'] == 'pag_taskmnger' ? 'active': '' ?>">
				<div class="iocn-link">
					<a href="?p=pag_taskmnger">
						<i class='bx bx-task'></i>
						<span class="dns_btnnme">Tareas&nbsp;y&nbsp;Proyectos</span>
					</a>
				</div>
			</li>

			<li class="dns_sdbarli <?php echo isset($_GET['p']) && $_GET['p'] == 'pag_warranty' ? 'active': '' ?>">
				<div class="iocn-link">
					<a href="?p=pag_warranty">
						<i class='bx bx-task'></i>
						<span class="dns_btnnme">Garantías</span>
					</a>
				</div>
			</li>
		</ul>
	</div>

	<section class="dns_pgesston">
		<div class="container-fluid m-0 py-0 px-2"> 
		    <div class="dns_stonhader border">
		        <div class="dns-bra-info">
		        <?php echo $pag_nme; ?> 
		        </div>
		        <div class="dns_infouser">
		        	<span for="sesionon"><?php print 'Hola '.$userinfo['unombre1'].' '.$userinfo['upaterno'];?></span>
		        	<a href="<?php print SITE_URL; ?>?q=logout"><i class='bx bx-log-in-circle'></i></a>
		        </div>
		    </div>
		    <div id="containerpags" class="">
		    <?php require 'pags/'.$pag.'.php';?>
		    </div>
		</div>
  	</section>
<script id="loadpagscript" type="text/javascript"></script>
<?php if (!empty($pag_script)) : ?>
<script>
  document.getElementById('loadpagscript').src = "<?php echo $base_url . $pag_script; ?>";
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script src="assets/tinymce/es.js"></script>
<!-- <script src="assets/js/jquery.ui.touch-punch.min.js"></script> -->
                <script type="text/javascript">
$(document).ready(function() {
  $('#ctndoraddcomments').on('click', '#show_addcomments', function() {
    $('#show_addcomments').slideUp();
    $('#addcomments').slideDown();
  });
  $('#ctndoraddcomments').on('click', '#hidden_addcomments', function() {
    $('#show_addcomments').slideDown();
    $('#addcomments').slideUp();
    tinymce.get('dtcmtros').setContent('');
  });

  $('#ctndoraddfiletocomments').on('click', '#show_addfiletocomments', function() {
    $('#show_addfiletocomments').slideUp();
    $('#addfiletocomments').slideDown();
  });
});
$('#pag_events').on('click', function() {
    pags();
});
  function pags(){
  	$.ajax({
  		type: 'POST',
  		url: 'modules/backofficeweb/events/pag.php',
  		data: { action: "hola" },
  		dataType: 'JSON',
  		success: function(response){
        $('#containerpags').html(response.html);
        $('#loadpagscript').attr('src', response.script );
  		},
  		error: function(xhr, status, error){
        console.error('Error en la solicitud AJAX:', error);
          $('#containerpags').html('<p>Ocurrió un error al cargar los datos.</p>');
  		}
  	});
  }

/**
   * Initiate TinyMCE Editorc
   */

const example_image_upload_handler = async (blobInfo, progress) => {
  // Comprimir la imagen antes de subirla
  const compressedBlob = await compressImage(blobInfo.blob());

  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', 'upload.php');

    xhr.upload.onprogress = (e) => {
      progress(e.loaded / e.total * 100);
    };

    xhr.onload = () => {
      if (xhr.status === 403) {
        reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
        return;
      }

      if (xhr.status < 200 || xhr.status >= 300) {
        reject('HTTP Error: ' + xhr.status);
        return;
      }

      const json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
        reject('Invalid JSON: ' + xhr.responseText);
        return;
      }

      resolve(json.location);
    };

    xhr.onerror = () => {
      reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };

    const formData = new FormData();
    formData.append('file', compressedBlob, blobInfo.filename());

    xhr.send(formData);
  });
};

function compressImage(blob) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(blob);
    reader.onload = event => {
      const img = new Image();
      img.src = event.target.result;
      img.onload = () => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0, img.width, img.height);
        canvas.toBlob(
          compressedBlob => {
            resolve(compressedBlob);
          },
          'image/webp', // Cambiado a formato WebP
          0.7 // Calidad de compresión, ajusta este valor según tus necesidades
        );
      };
    };
    reader.onerror = error => reject(error);
  });
}

  const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isSmallScreen = window.matchMedia('(max-width: 250px)').matches;

  tinymce.init({
    selector: '#dtdccon',
    images_upload_handler: example_image_upload_handler,
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons autoresize',
    editimage_cors_hosts: ['picsum.photos'],
    menubar: '',
    toolbar: 'bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | media link | ltr rtl',
    toolbar_sticky: false,
    toolbar_sticky_offset: isSmallScreen ? 102 : 108, 
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
    toolbar_mode: 'sliding',
    contextmenu: 'bold',
    // Configuración del plugin autoresize
    autoresize_bottom_margin: 20, // Margen inferior al que se expande el editor
    autoresize_min_height: 150, // Altura mínima del editor
    autoresize_max_height: 800, // Altura máxima del editor
    autoresize_overflow_padding: 20, // Espacio adicional para el contenido que se desplaza
    maxLength: 5000,

    // Función que se ejecuta cuando el contenido cambia
    setup: function (editor) {
        editor.on('input', function () {
            // Obtener el contenido actual
            var content = editor.getContent({ format: 'text' });

            // Verificar la longitud del contenido
            if (content.length > 5000) {
                // Mostrar una advertencia si se supera el límite
                alert('El contenido ha superado el límite de 5000 caracteres.');
                
                // Puedes implementar lógica adicional aquí, como truncar el contenido o detener al usuario de seguir escribiendo.
            }
        });
    },
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
    language: 'es',
    branding: false,
  });

tinymce.init({
    selector: '#dtcmtros',
    images_upload_handler: example_image_upload_handler,
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons autoresize',
    editimage_cors_hosts: ['picsum.photos'],
    menubar: '',
    toolbar: 'bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | media link | ltr rtl',
    toolbar_sticky: false,
    toolbar_sticky_offset: isSmallScreen ? 102 : 108, 
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
    toolbar_mode: 'sliding',
    contextmenu: 'bold',
    // Configuración del plugin autoresize
    autoresize_bottom_margin: 20, // Margen inferior al que se expande el editor
    autoresize_min_height: 150, // Altura mínima del editor
    autoresize_max_height: 800, // Altura máxima del editor
    autoresize_overflow_padding: 20, // Espacio adicional para el contenido que se desplaza
    maxLength: 5000,

    // Función que se ejecuta cuando el contenido cambia
    setup: function (editor) {
        editor.on('input', function () {
            // Obtener el contenido actual
            var content = editor.getContent({ format: 'text' });

            // Verificar la longitud del contenido
            if (content.length > 5000) {
                // Mostrar una advertencia si se supera el límite
                alert('El contenido ha superado el límite de 5000 caracteres.');
                
                // Puedes implementar lógica adicional aquí, como truncar el contenido o detener al usuario de seguir escribiendo.
            }
        });
    },
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
    language: 'es',
    branding: false,
  });
                </script>

</body>
</html>
<script>

$(document).ready(function() {
  var arrows = $('.arrow');
  var pcpllis = $('.dns_sdbarli');

  arrows.on('click', function() {
    var ul = $(this).parent().next();
    ul.toggleClass('show');
  });

  pcpllis.on('mouseover', function() {
    var ul = $(this).find('.dns_sdbarsubrul');
    var span =  $(this).find('.dns_btnnme');
    ul.addClass('show');
    span.addClass('dns_showbtnnme');
  });
  pcpllis.on('mouseout', function() {
    var ul = $(this).find('.dns_sdbarsubrul');
    var span =  $(this).find('.dns_btnnme');
    ul.removeClass('show');
    span.removeClass('dns_showbtnnme');
  });
});

$(document).ready(function() {
  $('#tggleSdbar').click(function() {
    if($('.dns_sdbar').hasClass('close')){
    	$('.dns_sdbar').removeClass('close');
    }
    else{
    	$('.dns_sdbar').addClass('close');
    }

  });

//Listar usuario en input y capturar iduser
$('#dtrpsble').on('input', function() {
var query = $(this).val();
if (query === '') {
    $('.dns_dtctndorltarpsble').removeClass("show"); // Ocultar el contenedor de resultados
    $('#ltarpsble').empty(); // Vaciar la lista de resultados
    return; // Salir de la función
}
if ((query).length > 0 ){
  //$('.dns_dtctndorltarpsble').addClass("show");
  //$('#dtctndorltarpsble').text(query) ;
  SarchCdeUser(query);
}
});
function SarchCdeUser(query) {
  $.ajax({
    type: 'POST',
    url: 'ajaxjs/user/sarchuser.php',
    data: { query: query },
    success: function(data) {
      if(data.trim() === 'Sin resultados'){
        $('.dns_dtctndorltarpsble').removeClass("show");
        $('#ltarpsble').empty(data);
      } else if (query === '') {
        $('.dns_dtctndorltarpsble').removeClass("show");
        $('#ltarpsble').empty(data);
      } else {
        $('.dns_dtctndorltarpsble').addClass("show");
        $('#ltarpsble').html(data);
      }
    }
  });
}
$('.dns_ltarpsble').on('click', '.dns_dtdteuser', function() {
	var query = $(this).text();
    var dteuser = $(this).find('.dteuser').text();
    var dtecdgo = $(this).find('.dtecdgo').text();
    $('#dtrpsble').val(dteuser);
    $('#dtcdgorpsble').text(dtecdgo);
    dtcdeuser = dtecdgo;
    $('.dns_dtctndorltarpsble').removeClass("show");
    $('#ltarpsble').empty();
});
$('#pag_orders').on('click', function() {
  $.ajax({
  		type: 'POST',
  		url: 'modules/orders/orders.php',
  		data: { action: 'list_orders' },
  		dataType: 'JSON',
  		success: function(response){
        $('#containerpags').html(response.message); 
  		},
  		error: function(xhr, status, error){
        console.error('Error en la solicitud AJAX:', error);
          $('#containerpags').html('<p>Ocurrió un error al cargar los datos.</p>');
  		}
  	});
});
$('#dtrpsble').keydown(function(e) {
  var $resultados = $('.dns_dtctndorltarpsble .dns_dtdteuser');
  var $resultadoSeleccionado = $('.dns_dtctndorltarpsble .dns_dtdteuser.slect');
  var index = $resultados.index($resultadoSeleccionado);

    if (e.keyCode === 40) { // Flecha abajo
        if (index === $resultados.length - 1) {

            $resultadoSeleccionado.removeClass('slect');
            $resultados.eq(0).addClass('slect');

            $('.dns_ltarpsble').scrollTop(0);
        } else {
            $resultadoSeleccionado.removeClass('slect');
            $resultados.eq(index + 1).addClass('slect');

            var containerHeight = $('.dns_ltarpsble').height();
            var itemHeight = $resultados.eq(index + 1).outerHeight(true);
            var scrollTo = (index + 1) * itemHeight;
            $('.dns_ltarpsble').scrollTop(scrollTo);
        }
    } else if (e.keyCode === 38) { // Flecha arriba
        if (index === 0) {

            $resultadoSeleccionado.removeClass('slect');
            $resultados.eq($resultados.length - 1).addClass('slect');

            $('.dns_ltarpsble').scrollTop($('.dns_ltarpsble')[0].scrollHeight);
        } else {
            $resultadoSeleccionado.removeClass('slect');
            $resultados.eq(index - 1).addClass('slect');

            var itemHeight = $resultados.eq(index - 1).outerHeight(true);
            var scrollTo = (index - 1) * itemHeight;
            $('.dns_ltarpsble').scrollTop(scrollTo);
        }
    } else if (e.keyCode === 13) { // Enter
      var dteuser = $('.dns_dtctndorltarpsble .dns_dtdteuser.slect .dteuser');
      var dtecdgo = $('.dns_dtctndorltarpsble .dns_dtdteuser.slect .dtecdgo');
      $('#dtrpsble').val(dteuser.text());
      dtcdeuser = dtecdgo.text();
      $('.dns_dtctndorltarpsble').removeClass("show");
      $('#ltarpsble').empty();
    }
});

});


</script>