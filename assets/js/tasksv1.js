// Función para animar el porcentaje y el círculo SVG
function animatePercentageAndCircle(valorDinamico) {
  var $porcentajeElemento = $('.percent .number .dns_h2');
  var $circuloSVG = $('.percent .dns_svg .dns_circle:nth-child(2)');
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

        // Puedes agregar un evento de cambio para manejar cualquier validación adicional si es necesario
$('#dtfchalmte').change(function() {
  // Obtener la fecha seleccionada en GMT-5
  const fechaSeleccionada = new Date($(this).val());
  const fechaSeleccionadaGMT5 = new Date(fechaSeleccionada.getTime() - 5 * 60 * 60 * 1000);
  // Verificar si la fecha seleccionada es al menos una hora después de la fecha actual en GMT-5
  if (fechaSeleccionadaGMT5 <= new Date(fechaActualGMT5.getTime() + 60 * 60 * 1000)) {
    // Sumar una hora a la fecha actual y actualizar el valor del campo
    const nuevaFecha = new Date(fechaActualGMT5.getTime() + 60 * 60 * 1000);
    const nuevaFechaFormatoInput = nuevaFecha.toISOString().slice(0, 16);
    $(this).val(nuevaFechaFormatoInput);
    // Puedes también mostrar un mensaje informativo si lo deseas
    alert('Se ha sumado una hora a la fecha y hora actual.');
  } else {
    // Aquí puedes agregar lógica adicional si es necesario
    console.log('Fecha seleccionada:', $(this).val());
  }
});


//Listar usuario en input y capturar iduser

//Boton Eficiencia
  $('#btnpgeefcecy').on('click', function() {
    var dttnmroid = "0";
    $.ajax({
      type: "POST",
      url: "ajaxjs/task/efcecy.php",
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
        url: "ajaxjs/task/araefcecy.php",
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
  $("#containermodalnewtask").toggleClass("open");
});

//Cerrar Modal nueva tarea
$("#csenewrgterstask").click(function() {
    $('#dtcadorid').val("");
    $('#dtrpsble').val("");
    $('#dtnbretra').val("");
    $('#dtdccon').val("");
    $('#dtfchalmte').val("");
    $('#dtlvelefcecy').val("");
    tinymce.get('dtdccon').setContent('');
    $('#ctnerfiles').empty();
    listaurl.length = 0;
    console.log(listaurl);
  $("#bgundmdal").fadeOut();
  $("#containermodalnewtask").toggleClass("open");
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

// Buscar task
$('#sarchtask').on('input', function() {
  var sarchtask = $(this).val();
  SarchTask(sarchtask);
});

// Fin Buscar Task

  //Modal Info Task
  var slcnaretpagarccon = document.getElementById("dtudteetpagarccon");

//Cerrar Modal detalles
  $("#csedtilstask").click(function() {
    $("#bgundmdal").fadeOut();
    $("#mdal_dtilstask").toggleClass("open");
  });

//Abre los detalles de las tareas
  $("#dns-ctndor-knbn").on("dblclick", ".dns_cardkban", function() {
    var idtask = $(this).find("#idtask").text();
    
    Getinfogc(idtask)
  });

  function Getinfogc(idtask){
    $.ajax({
      type: "POST",
      url: "ajaxjs/task/openkbantask.php",
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
          document.getElementById('dttnmroid').textContent = response.dttnmroid;
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
      $("#dns-ctndor-knbn .dns_ctinerclumn").sortable({
        connectWith: ".dns_ctinerclumn",
        placeholder: "task-placeholder",
        items:".dns_cardkban",

        receive: function(event, ui) {
          var etdo = $(this).attr("id");
          var taskId = ui.item.attr("id");
          var lveldlvry = ui.item.find("#lveldlvry").text();
          var dns_ctdorcmtros = ui.item.find(".dns_ctdorcmtros").text();
          var columnNum = parseInt($(this).find(".dns_nberclumn").text());

          console.log({etdo,taskId,lveldlvry });

            $.ajax({
            url: 'ajaxjs/task/udtekbantask.php',
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
              SarchTask("");
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
  // Obtener la fecha seleccionada en GMT-5
  const fechaSeleccionada = new Date($(this).val());
  const fechaSeleccionadaGMT5 = new Date(fechaSeleccionada.getTime() - 5 * 60 * 60 * 1000);
  // Verificar si la fecha seleccionada es al menos una hora después de la fecha actual en GMT-5
  if (fechaSeleccionadaGMT5 <= new Date(fechaActualGMT5.getTime() + 60 * 60 * 1000)) {
    // Sumar una hora a la fecha actual y actualizar el valor del campo
    const nuevaFecha = new Date(fechaActualGMT5.getTime() + 60 * 60 * 1000);
    const nuevaFechaFormatoInput = nuevaFecha.toISOString().slice(0, 16);
    $(this).val(nuevaFechaFormatoInput);
    // Puedes también mostrar un mensaje informativo si lo deseas
    alert('Se ha sumado una hora a la fecha y hora actual.');

    // Realizar el registro<
    var dttfchalmte = nuevaFechaFormatoInput;
    var dttnmroid = document.getElementById('dttnmroid').textContent;
    var dttnvel = document.getElementById('dttnvel').textContent;


    $.ajax({
      type: "POST",
      url: "ajaxjs/task/udtedadlnetask.php",
      data: { dttnmroid: dttnmroid, dttfchalmte: dttfchalmte, dttnvel: dttnvel },
      dataType: 'json',
      success: function(response){
        if(response.sttus) {
          alert(response.msge);
          document.getElementById('dtlneatepo').innerHTML = response.dtlneatepo;
        } else {
          alert(response.msge);
        }
      },
      error: function(error){
        console.log(error);
      }
    });

  } else {
    // Si la fecha seleccionada cumple con las condiciones, realizar la operación de ampliar fecha límite
    var dttfchalmte = $(this).val();
    var dttnmroid = document.getElementById('dttnmroid').textContent;
    var dttnvel = document.getElementById('dttnvel').textContent;
    $.ajax({
      type: "POST",
      url: "ajaxjs/task/udtedadlnetask.php",
      data: { dttnmroid: dttnmroid, dttfchalmte: dttfchalmte, dttnvel: dttnvel },
      dataType: 'json',
      success: function(response){
        if(response.sttus) {
          alert(response.msge);
          document.getElementById('dtlneatepo').innerHTML = response.dtlneatepo;
        } else {
          alert(response.msge);
        }
      },
      error: function(error){
        console.log(error);
      }
    });
  }
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
  //var dtcmtros = document.getElementById('dtcmtros').value;
  var dtcmtros = tinymce.get('dtcmtros').getContent();
  var dtlistaurl = listaurl;
  $.ajax({
    type: "POST",
    url: "ajaxjs/task/addcmtstask.php",
    data: { dttnmroid: dttnmroid, dtcmtros: dtcmtros, dtlistaurl: dtlistaurl },
    dataType: 'json',
    success: function(response) {
      if(response.sttus){
        alert(response.message);
        $('#dtcmtros').val("");
        tinymce.get('dtcmtros').setContent('');
        $('#ctnerfilestocomments').empty();
        listaurl.length = 0;
        $('#show_addcomments').slideDown();
        $('#addcomments').slideUp();
        $('#dtlneatepo').html(response.dtlneatepo);
        $('#dttcmtros').html(response.dttracmtros);
      }
      else{
        alert(response.message);

      }

    },
    error: function(error){
      console.error(error);
    }
  });
}
//Agregar comentario
  var listaurl = [];
// Modal para registro de nueva tarea
  $("#btn_gadargarccon").on('click', function() {
    gadargarccon(listaurl);
  });

  $("#btn_crrarrgarccon").on('click', function() {
    $("#bgundmdal").fadeOut(); // nuevo cliente Modal
    $("#containermodalnewtask").toggleClass("open"); // div derecha nuevo cliente
    $('#dtcadorid').val("");
    $('#dtrpsble').val("");
    $('#dtnbretra').val("");
    $('#dtdccon').val("");
    $('#dtfchalmte').val("");
    $('#dtlvelefcecy').val("");
    tinymce.get('dtdccon').setContent('');
    $('#ctnerfiles').empty();
    listaurl.length = 0;
    console.log(listaurl);
  });

  $('#btnuploadfile').click(function() {
    $('#file').trigger('click'); // Al hacer clic en el botón, se activa el clic en el input de archivo oculto
  });
  $('#file').change(function() {
    var fileInput = $(this)[0].files[0];
    var formData = new FormData();
    formData.append('file', fileInput);
    $('.dns_taskuploadfile').append('<div class="dns_bgloading"><i class="bx bx-loader-circle bx-spin bx-flip-horizontal"></i></div>');
    $.ajax({
      url: 'uploadfile.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json', // Esperamos una respuesta JSON
      success: function(response) {
        $('#ctnerfiles').append(response.downloadLink + "<br>");
        $('.dns_taskuploadfile .dns_bgloading').remove();
        listaurl.push(response.fileUrl);
        console.log(listaurl);
      }
    });
  });

  $('#btnuploadfiletocomments').click(function() {
    $('#filetocomments').trigger('click'); // Al hacer clic en el botón, se activa el clic en el input de archivo oculto
  });
  $('#filetocomments').change(function() {
    var fileInput = $(this)[0].files[0];
    var formData = new FormData();
    formData.append('file', fileInput);
    $('.dns_taskuploadfiletocomments').append('<div class="dns_bgloading"><i class="bx bx-loader-circle bx-spin bx-flip-horizontal"></i></div>');
    $.ajax({
      url: 'uploadfile.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json', // Esperamos una respuesta JSON
      success: function(response) {
        $('#ctnerfilestocomments').append(response.downloadLink + "<br>");
        $('.dns_taskuploadfiletocomments .dns_bgloading').remove();
        listaurl.push(response.fileUrl);
        console.log(listaurl);
      }
    });
  });

$(document).on('click', '.dns_ctnerbtndownloadfile .bx-x', function() {
  var listItem = $(this).closest('.dns_ctnerbtndownloadfile');
  var fileUrl = listItem.find('.dns_btndownloadfile').attr('href');
  var index = listaurl.indexOf(fileUrl);
  $('.dns_taskuploadfile').append('<div class="dns_bgloading"><i class="bx bx-loader-circle bx-spin bx-flip-horizontal"></i></div>');
  $.ajax({
    url: 'deletefile.php', // Script para eliminar archivos
    type: 'POST',
    data: { fileUrl: fileUrl },
    success: function(response) {
      if (response == 'success') {
        listItem.remove();
        if (index !== -1) {
          listaurl.splice(index, 1);
        }
        console.log(listaurl);
      } else {
        alert('Error al eliminar el archivo.');
      }
      $('.dns_taskuploadfile .dns_bgloading').remove();
    }
  });
});

function gadargarccon(listaurl){
  //alert(idcete + psnalid);
  var dtcadorid = document.getElementById('dtcadorid').value;
  var dtnbretra = document.getElementById('dtnbretra').value;
  var dtdccon = tinymce.get('dtdccon').getContent();
  var dtrpsble = document.getElementById('dtrpsble').value;
  var dtfchalmte = document.getElementById('dtfchalmte').value;
  var dtlvelefcecy = document.getElementById('dtlvelefcecy').value;
  var dtlistaurl = listaurl;
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
    url: "ajaxjs/task/svenewtask.php",
    data: { dtcadorid: dtcadorid, dtnbretra: dtnbretra, dtdccon: dtdccon, dtcdeuser: dtcdeuser, dtfchalmte: dtfchalmte, dtlvelefcecy: dtlvelefcecy, dtlistaurl: dtlistaurl },
    dataType: 'json',
    success: function(response) {
      if (response.sttus) {
        $('#dtcadorid').val("");
        $('#dtrpsble').val("");
        $('#dtnbretra').val("");
        $('#dtdccon').val("");
        $('#dtfchalmte').val("");
        $('#dtlvelefcecy').val("");
        tinymce.get('dtdccon').setContent('');
        $('#ctnerfiles').empty();
        listaurl.length = 0;
        console.log(listaurl);

        $("#bgundmdal").fadeOut();
        $("#containermodalnewtask").toggleClass("open");
        alert(response.message);
        SarchTask("");
      } else {
        alert("Posible problema al registrar");
      }
    },
    error: function(error) {
      console.error(error);
    }
  });

}

//funcion Buscar tarea
function SarchTask(sarchtask){
  $.ajax({
    type: "POST",
    url: "ajaxjs/task/sarchtask.php",
    data: {sarchtask: sarchtask },
    dataType: 'json',
    success: function(response){
      $('#dns-ctndor-knbn').html(response.html);

      //Actualizar tarea
    $("#dns-ctndor-knbn .dns_ctinerclumn").sortable({
  connectWith: ".dns_ctinerclumn",
  placeholder: "task-placeholder",
  items: ".dns_cardkban",

  receive: function(event, ui) {

    var etdo = $(this).attr("id");
    var taskId = ui.item.find("#idtask").text().trim();
    var lveldlvry = ui.item.find("#lveldlvry").text();
    var dns_ctdorcmtros = ui.item.find(".dns_ctdorcmtros").text();

    console.log({ etdo, taskId, lveldlvry, dns_ctdorcmtros });

    $.ajax({
      url: 'ajaxjs/task/udtekbantask.php',
      type: 'POST',
      dataType: 'json',
      data: {
        etdo,
        taskId,
        lveldlvry,
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
    },
    error: function(error){
      console.error(error);
    }
  });
};