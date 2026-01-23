<script type="text/javascript">

// Función para animar el porcentaje y el círculo SVG
function animatePercentageAndCircle(valorDinamico) {
  var $porcentajeElemento = $('.percent .number h2');
  var $circuloSVG = $('.percent svg circle:nth-child(2)');
  valorDinamico = parseFloat(valorDinamico.toFixed(2));

  $({ porcentaje: 0 }).animate(
  {
    porcentaje: valorDinamico
  },
  {
    duration: 3000,
    step: function () {
      $porcentajeElemento.text(Math.floor(this.porcentaje) + '%');
      var dashoffset = 440 - (440 * this.porcentaje) / 100;
      $circuloSVG.css('stroke-dashoffset', dashoffset);
    },
    complete: function () {
      console.log('Animación completa');
    }
  }
  );
}
// Función para animar el porcentaje y el círculo SVG


// Botones left and Rigth OverFlow
var scrollableDiv = document.getElementById("dns_boardkban");
var leftButton = document.getElementById("dns_arrowleftkban");
var rightButton = document.getElementById("dns_arrowrightkban");
var isScrolling = false;
var scrollSpeed = 10; // Velocidad de desplazamiento
leftButton.addEventListener("mouseenter", function() {
  startScroll("left");
});
rightButton.addEventListener("mouseenter", function() {
  startScroll("right");
});
leftButton.addEventListener("mouseleave", stopScroll);
rightButton.addEventListener("mouseleave", stopScroll);
function startScroll(direction) {
  if (!isScrolling) {
    isScrolling = true;
    scroll(direction);
  }
}
function scroll(direction) {
  var scrollAmount = direction === "left" ? -scrollSpeed : scrollSpeed;
  scrollableDiv.scrollLeft += scrollAmount;
  if (scrollableDiv.scrollLeft <= 0 || scrollableDiv.scrollLeft >= scrollableDiv.scrollWidth - scrollableDiv.clientWidth) {
    stopScroll();
    return;
  }
  if (isScrolling) {
    requestAnimationFrame(function() {
      scroll(direction);
    });
  }
}
function stopScroll() {
  isScrolling = false;
}
// Botones left and Rigth OverFlow

var dtcdeuser;
//query
$(document).ready(function() {

            // $("#dns-btncseudtegr").click(function() {
            //   $(".dns-ctndr-udtegarcconModal").fadeOut();
            //   $(".dns_ctnermdalr").toggleClass("open");
            // });


// Obtener la fecha y hora actual en GMT-5
const fechaActual = new Date();
const fechaActualGMT5 = new Date(fechaActual.getTime() - 5 * 60 * 60 * 1000);
const fechaActualFormatoInput = fechaActualGMT5.toISOString().slice(0, 16);
// Establecer el valor mínimo del campo de entrada como la fecha actual
$('#dtfchalmte').attr('min', fechaActualFormatoInput);

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

function SarchCdeUser(query) {
  $.ajax({
    type: 'POST',
    url: 'buscar.php',
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
//Listar usuario en input y capturar iduser

//Boton Eficiencia
  $('#btnpgeefcecy').on('click', function() {
    var dttnmroid = "0";
    $.ajax({
      type: "POST",
      url: "./pge_efcecy.php",
      data: { dttnmroid: dttnmroid },
      dataType: 'json',
      success: function(response){
        $('#dns-ctndor-knbn').html(response.html);
        var valorDinamico = $('.tjta').data('value');
        animatePercentageAndCircle(valorDinamico);
      },
      error: function(error){
        console.error(error);
      }
    });
  });

//Lista de area en eficiencia
  $("#dns-ctndor-knbn").on("change", "#araefcecy", function() {
    var araefcecy = $(this).val();
      $.ajax({
        type: "POST",
        url: "./araefcecy.php",
        data: { araefcecy: araefcecy },
        dataType: 'json',
        success: function(response){
          $("#listaraefcecy").html(response.html);
        },
        error: function(error){
          console.error(error);
        }
      });
  });


//Modal Crear nueva tarea
$(".dns_btnnewrgter").click(function() {
  $("#bgundmdal").fadeIn();
  $(".dns_ctnermdalr").toggleClass("open");
});

//Cerrar Modal nueva tarea
$("#csenewrgterstask").click(function() {
  $("#bgundmdal").fadeOut();
  $(".dns_ctnermdalr").toggleClass("open");
});

// Esto para validar el registro en tiempo real
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


  // $("#dtnbretra").on("input change", function() {
  //   var dtnbretra = $(this).val();
  //   var dtnbretra_filter = dtnbretra.replace(/[^A-Za-z0-9.,áéíóúÁÉÍÓÚñÑ -]/g, '');
  //   if(dtnbretra === '')
  //   {
  //     document.getElementById("msj_dtnbretra").style.display = 'block';
  //     document.getElementById("msj_dtnbretra").style.color = 'red';
  //     document.getElementById("msj_dtnbretra").textContent = "Campo obligatorio";
  //     document.getElementById("dtnbretra").style.borderColor = 'red';
  //     return;
  //   }
    // if(dtnbretra !== dtnbretra_filter)
    // {
    //   document.getElementById("msj_dtnbretras").style.display = 'block';
    //   document.getElementById("msj_dtnbretra").style.color = 'red';
    //   document.getElementById("msj_dtnbretra").textContent = "Solo se permiten letras y números";
    //   document.getElementById("dtnbretra").style.borderColor = 'red';
    //   return;
    // }
  //   document.getElementById("dtnbretra").style.borderColor = 'green';
  //   document.getElementById("msj_dtnbretra").style.display = 'none';
  // });
  $("#dtdccon").on("input change", function() {
    var dtdccon = $(this).val();
    var dtdccon_filter = dtdccon.replace(/[^A-Za-z0-9.,áéíóúÁÉÍÓÚñÑ -]/g, '');
    if(dtdccon === '')
    {
      document.getElementById("msj_dtdccon").style.display = 'block';
      document.getElementById("msj_dtdccon").style.color = 'red';
      document.getElementById("msj_dtdccon").textContent = "Campo obligatorio";
      document.getElementById("dtdccon").style.borderColor = 'red';
      return;
    }
    // if(dtdccon !== dtdccon_filter)
    // {
    //   document.getElementById("msj_dtdccons").style.display = 'block';
    //   document.getElementById("msj_dtdccon").style.color = 'red';
    //   document.getElementById("msj_dtdccon").textContent = "Solo se permiten letras y números";
    //   document.getElementById("dtdccon").style.borderColor = 'red';
    //   return;
    // }
    document.getElementById("dtdccon").style.borderColor = 'green';
    document.getElementById("msj_dtdccon").style.display = 'none';
  });
  $("#dtrpsble").on("input change", function() {
    var dtrpsble = $(this).val();
    var dtrpsble_filter = dtrpsble.replace(/[^A-Za-z0-9.,áéíóúÁÉÍÓÚñÑ -]/g, '');
    if(dtrpsble === '')
    {
      document.getElementById("msj_dtrpsble").style.display = 'block';
      document.getElementById("msj_dtrpsble").style.color = 'red';
      document.getElementById("msj_dtrpsble").textContent = "Campo obligatorio";
      document.getElementById("dtrpsble").style.borderColor = 'red';
      return;
    }
    document.getElementById("dtrpsble").style.borderColor = 'green';
    document.getElementById("msj_dtrpsble").style.display = 'none';
  });
  $("#dtlvelefcecy").on("input change", function() {
    var dtlvelefcecy = $(this).val();
    var dtlvelefcecy_filter = dtlvelefcecy.replace(/[^A-Za-z0-9.,áéíóúÁÉÍÓÚñÑ -]/g, '');
    if(dtlvelefcecy === '')
    {
      document.getElementById("msj_dtlvelefcecy").style.display = 'block';
      document.getElementById("msj_dtlvelefcecy").style.color = 'red';
      document.getElementById("msj_dtlvelefcecy").textContent = "Campo obligatorio";
      document.getElementById("dtlvelefcecy").style.borderColor = 'red';
      return;
    }
    document.getElementById("dtlvelefcecy").style.borderColor = 'green';
    document.getElementById("msj_dtlvelefcecy").style.display = 'none';
  });
// Fin re validación

// continua como javascript puro más abajo



  //Modal Info Task
  var slcnaretpagarccon = document.getElementById("dtudteetpagarccon");

//Cerrar Modal detalles
  $("#csedtilstask").click(function() {
    $("#bgundmdal").fadeOut();
    $("#mdal_dtilstask").toggleClass("open");
  });

//Abre los detalles de las tareas
  $(".dns_cardkban").on("dblclick", function() {
    var idtask = $(this).find("#idtask").text();
    Getinfogc(idtask)
  });

  function Getinfogc(idtask){
    $.ajax({
      type: "POST",
      url: "./get_infotask.php",
      data: { idtask: idtask},
      dataType: 'json',
      success: function(response) {
        if (response.sttus) {
          idgarccon = response.dttnmroid;
          // etpagarccon = response.dttetdo;
          // for (var i = 0; i < slcnaretpagarccon.options.length; i++) {
          //   if (slcnaretpagarccon.options[i].value === etpagarccon) {
          //     slcnaretpagarccon.options[i].selected = true;
          //     break; // Termina el ciclo si encuentra la opción
          //   }
          // }
          document.getElementById('dttnmroid').textContent = response.dttnmroid.toString().padStart(3, '0');
          document.getElementById('dttttlo').textContent = response.dttttlo;
          document.getElementById('dtucador').textContent = response.dtucador;
          document.getElementById('dturpsble').textContent = response.dturpsble;
          document.getElementById('dttfchareg').textContent = response.dttfchareg;
          document.getElementById('dttfchalmte').value = response.dttfchalmte;
          document.getElementById('dttetdofchalmte').innerHTML = response.dttetdofchalmte;
          document.getElementById('dtlneatepo').innerHTML = response.dtlneatepo;
          document.getElementById('dttetdo').innerHTML = response.dttetdo;
          document.getElementById('dttnvel').innerHTML = response.dttnvel;
          document.getElementById('dttdccon').innerHTML = response.dttdccon;
          document.getElementById('dttcmtros').innerHTML = response.dttracmtros;
          $("#bgundmdal").fadeIn();
          $("#mdal_dtilstask").toggleClass("open");

        } else {
          alert(response.message);
        }
      },
      error: function(error) {
        console.error(error);
      }
    });
  };

//Actualizar tarea
      $(".dns_ctinerclumn").sortable({
        connectWith: ".dns_ctinerclumn",
        placeholder: "task-placeholder",
        receive: function(event, ui) {
          var etdo = $(this).attr("id");
          var taskId = ui.item.attr("id");
          var lveldlvry = ui.item.find("#lveldlvry").text();
          var dns_ctdorcmtros = ui.item.find(".dns_ctdorcmtros").text();
          var columnNum = parseInt($(this).find(".dns_nberclumn").text());

            $.ajax({
            url: './udte_task.php',
            type: 'POST',
            dataType: 'json',
            data: {
              etdo: etdo,
              taskId: taskId,
              lveldlvry: lveldlvry,
              detallesColumna: dns_ctdorcmtros
            },
            success: function(response) {
              alert(response.msge);
            },
            error: function(xhr, status, error) {
              console.error(error);
            }
          });
        }
      });
//Actualizar tarea

// botones para agregar y cancelar comentarios
$("#evarcmtro").click(function() {
  add_cmts();
}); 
$("#cclarcmtro").click(function() {
  document.getElementById('dtcmtros').value = "";
});

//Ampliar Fecha Limite
$("#dttfchalmte").on('change', function() {
  var dttfchalmte = $(this).val();
  var dttnmroid = document.getElementById('dttnmroid').textContent;
  var dttnvel = document.getElementById('dttnvel').textContent;
  $.ajax({
    type: "POST",
    url: "./udte_dadlnetask.php",
    data: { dttnmroid: dttnmroid, dttfchalmte: dttfchalmte, dttnvel: dttnvel },
    dataType: 'json',
    success: function(response){
      if(response.sttus)
      {
        alert(response.msge);
        document.getElementById('dtlneatepo').innerHTML = response.dtlneatepo;
      }
      else
      {
        alert(response.msge);
      }
    },
    error: function(error){
      console.log(error);
    }
  });
  //alert(dttfchalmte);
});

// Actualizar etapa desde el modal detalles
  $("#dtudteetpagarccon").on("change", function() {
    var dtudteetpagarccon = $(this).val();
    var dttnmroid = document.getElementById('dttnmroid').textContent;
    var dttnvel = $('#dttnvel').text();
    //alert(dttnmroid.textContent);
    $.ajax({
      type: "POST",
      url: "./udte_mdaltask.php",
      data: { dttnmroid: dttnmroid, dtudteetpagarccon: dtudteetpagarccon, dttnvel: dttnvel },
      dataType: 'json',
      success: function(response){
        if(response.sttus)
        {
          alert(response.dtudteetpagarccon);
          document.getElementById('dtlneatepo').innerHTML = response.dtlneatepo;
        }
        else
        {
          $("#dtudteetpagarccon").val("En Progreso");
          alert("Solo el creador puede Completar la tarea.");
        }

      },
      error: function(error){
        console.error(error);
      }
    });
  });
// Actualizar etapa desde el modal detalles

});
//jquery

//Agregar comentario
function add_cmts(){
  var dttnmroid = document.getElementById('dttnmroid').textContent;
  var dtcmtros = document.getElementById('dtcmtros').value;
  $.ajax({
    type: "POST",
    url: "./add_cmts.php",
    data: { dttnmroid: dttnmroid, dtcmtros: dtcmtros },
    dataType: 'json',
    success: function(response) {
      alert(response.message);
      document.getElementById('dtcmtros').value = "";
      document.getElementById('dtlneatepo').innerHTML = response.dtlneatepo;
      document.getElementById('dttcmtros').innerHTML = response.dttracmtros;
    },
    error: function(error){
      console.error(error);
    }
  });
}
//Agregar comentario

// Modal para registro de nueva tarea
document.addEventListener('DOMContentLoaded', function() {
  var btn_gadargarccon = document.getElementById('btn_gadargarccon');
  var btn_crrarrgarccon = document.getElementById('btn_crrarrgarccon');

  var campoFecha = document.getElementById("dtfchalmte");
  var fechaActual = new Date();
  fechaActual.setDate(fechaActual.getDate() + 8);
  var anio = fechaActual.getFullYear();
  var mes = (fechaActual.getMonth() + 1).toString().padStart(2, "0");
  var dia = fechaActual.getDate().toString().padStart(2, "0");
  var nuevaFecha = anio + "-" + mes + "-" + dia;
  campoFecha.value = nuevaFecha;


  btn_gadargarccon.addEventListener('click', function() {
    gadargarccon();
  });

  btn_crrarrgarccon.addEventListener('click', function() {
    $("#bgundmdal").fadeOut(); // nuevo cliente Modal
    $(".dns_ctnermdalr").toggleClass("open"); // div derecha nuevo cliente
  });
});

function gadargarccon(){
  //alert(idcete + psnalid);
  var dtcadorid = document.getElementById('dtcadorid').value;
  var dtnbretra = document.getElementById('dtnbretra').value;
  var dtdccon = document.getElementById('dtdccon').value;
  var dtrpsble = document.getElementById('dtrpsble').value;
  var dtfchalmte = document.getElementById('dtfchalmte').value;
  var dtlvelefcecy = document.getElementById('dtlvelefcecy').value;

    // var dtnbretra_filter = dtnbretra.replace(/[^A-Za-z0-9.,áéíóúÁÉÍÓÚñÑ -]/g, '');
    // if(dtnbretra === '')
    // {
    //   document.getElementById("msj_dtnbretra").style.display = 'block';
    //   document.getElementById("msj_dtnbretra").style.color = 'red';
    //   document.getElementById("msj_dtnbretra").textContent = "Campo obligatorio";
    //   document.getElementById("dtnbretra").style.borderColor = 'red';
    //   return;
    // }
/*    if(dtnbretra !== dtnbretra_filter)
    {
      document.getElementById("msj_dtnbretra").style.display = 'block';
      document.getElementById("msj_dtnbretra").style.color = 'red';
      document.getElementById("msj_dtnbretra").textContent = "Solo se permiten letras y números";
      document.getElementById("dtnbretra").style.borderColor = 'red';
      return;
    }*/
    document.getElementById("dtnbretra").style.borderColor = 'green';
    document.getElementById("msj_dtnbretra").style.display = 'none';


    var dtdccon_filter = dtdccon.replace(/[^A-Za-z0-9.,áéíóúÁÉÍÓÚñÑ -]/g, '');
    if(dtdccon === '')
    {
      document.getElementById("msj_dtdccon").style.display = 'block';
      document.getElementById("msj_dtdccon").style.color = 'red';
      document.getElementById("msj_dtdccon").textContent = "Campo obligatorio";
      document.getElementById("dtdccon").style.borderColor = 'red';
      return;
    }
    // if(dtdccon !== dtdccon_filter)
    // {
    //   document.getElementById("msj_dtdccon").style.display = 'block';
    //   document.getElementById("msj_dtdccon").style.color = 'red';
    //   document.getElementById("msj_dtdccon").textContent = "Solo se permiten letras y números";
    //   document.getElementById("dtdccon").style.borderColor = 'red';
    //   return;
    // }
    document.getElementById("dtdccon").style.borderColor = 'green';
    document.getElementById("msj_dtdccon").style.display = 'none';
    if(dtrpsble === '')
    {
      document.getElementById("msj_dtrpsble").style.display = 'block';
      document.getElementById("msj_dtrpsble").style.color = 'red';
      document.getElementById("msj_dtrpsble").textContent = "Campo obligatorio";
      document.getElementById("dtrpsble").style.borderColor = 'red';
      return;
    }
    // if(dtdccon !== dtdccon_filter)
    // {
    //   document.getElementById("msj_dtdccon").style.display = 'block';
    //   document.getElementById("msj_dtdccon").style.color = 'red';
    //   document.getElementById("msj_dtdccon").textContent = "Solo se permiten letras y números";
    //   document.getElementById("dtdccon").style.borderColor = 'red';
    //   return;
    // }
    document.getElementById("dtrpsble").style.borderColor = 'green';
    document.getElementById("msj_dtrpsble").style.display = 'none';

    if(dtcdeuser === '')
    {
      document.getElementById("msj_dtrpsble").style.display = 'block';
      document.getElementById("msj_dtrpsble").style.color = 'red';
      document.getElementById("msj_dtrpsble").textContent = "Campo obligatorio";
      document.getElementById("dtrpsble").style.borderColor = 'red';
      return;
    }
  if(dtfchalmte === '')
  {
    document.getElementById("msj_dtfchalmte").style.display = 'block';
    document.getElementById("msj_dtfchalmte").style.color = 'red';
    document.getElementById("msj_dtfchalmte").textContent = "Campo obligatorio";
    document.getElementById("dtfchalmte").style.borderColor = 'red';
    return;
  }
  document.getElementById("msj_dtfchalmte").style.display = 'none';
  document.getElementById("dtfchalmte").style.borderColor = 'green';
    if(dtlvelefcecy === '')
    {
      document.getElementById("msj_dtlvelefcecy").style.display = 'block';
      document.getElementById("msj_dtlvelefcecy").style.color = 'red';
      document.getElementById("msj_dtlvelefcecy").textContent = "Campo obligatorio";
      document.getElementById("dtlvelefcecy").style.borderColor = 'red';
      return;
    }
    // if(dtdccon !== dtdccon_filter)
    // {
    //   document.getElementById("msj_dtdccon").style.display = 'block';
    //   document.getElementById("msj_dtdccon").style.color = 'red';
    //   document.getElementById("msj_dtdccon").textContent = "Solo se permiten letras y números";
    //   document.getElementById("dtdccon").style.borderColor = 'red';
    //   return;
    // }
    document.getElementById("dtlvelefcecy").style.borderColor = 'green';
    document.getElementById("msj_dtlvelefcecy").style.display = 'none';


  $.ajax({
    type: "POST",
    url: "save_newtask.php", // Buscar DNI
    data: { dtcadorid: dtcadorid, dtnbretra: dtnbretra, dtdccon: dtdccon, dtcdeuser: dtcdeuser, dtfchalmte: dtfchalmte, dtlvelefcecy: dtlvelefcecy },
    dataType: 'json',
    success: function(response) {
      if (response.sttus) {
        document.getElementById('dtcadorid').value = '';
        document.getElementById('dtrpsble').value = '';
        document.getElementById('dtnbretra').value = '';
        document.getElementById('dtdccon').value = '';
        document.getElementById('dtfchalmte').value = '';
        document.getElementById('dtlvelefcecy').value = '';
        $("#bgundmdal").fadeOut();
        $(".dns_ctnermdalr").toggleClass("open");
        alert("Tarea creada.");
        window.location.href = "index.php?p=pag_mngertask";
      } else {
        alert("Posible problema al registrar");
      }
    },
    error: function(error) {
      console.error(error);
    }
  });

}

</script>