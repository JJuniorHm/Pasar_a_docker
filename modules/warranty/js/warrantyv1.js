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

//query
$(document).ready(function() { 

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
 
// Fin Buscar Task
  
 

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

    // Realizar el registro
 

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


  // Buscar task
  $('#sarchtask').on('input', function() {
    var sarchtask = $(this).val();
    SarchTask(sarchtask);
  });
  SarchTask('');
  
  $('#insert_w').click( function() {
    insert_w();
  });
function insert_w(){

  $.ajax({
    type: "POST",
    url: "modules/warranty/ajaxjs/insert_w.php",
    data: { ccodcli: $('#ccodcli').val(), wvaucher: $('#wvaucher').val(), wpriceproduct: $('#wpriceproduct').val(), codigo: $('#codigo').val(), descripcion: $('#descripcion').val(), categoria: $('#categoria').val(), subcategoria: $('#subcategoria').val(), marca: $('#marca').val(), waccessories: $('#waccessories').val(), serialnumber: $('#serialnumber').val(), wprpc: $('#wprpc').val(), wequipmentstatus: $('#wequipmentstatus').val(), wdiagnostic: $('#wdiagnostic').val(), wproblemsdetected: $('#wproblemsdetected').val(), wconcludingremarks: $('#wconcludingremarks').val(), dtfchalmte: $('#dtfchalmte').val() },
    dataType: 'json',
    success: function(response) {
      if (response.status) {
        SarchTask("");
        $('#ccodcli').val('');
        $('#wvaucher').val('');
        $('#wpriceproduct').val('');
        $('#codigo').val('');
        $('#descripcion').val('');
        $('#categoria').val('');
        $('#subcategoria').val('');
        $('#marca').val('');
        $('#waccessories').val('');
        $('#serialnumber').val('');
        $('#wprpc').val('');
        $('#wequipmentstatus').val('');
        $('#wdiagnostic').val('');
        $('#wproblemsdetected').val('');
        $('#wconcludingremarks').val('');
        $('#dtfchalmte').val('');
        $("#bgundmdal").fadeOut();
        $('#containermodalinsert').prev('.dns_backgroundmodal').fadeOut('slow', function() { $(this).remove(); });
        $("#containermodalinsert").toggleClass("open");
        alert(response.message);
      } else {
        $('#'+response.inputdata).addClass(response.validation);
        alert(response.message);
        console.log(response.message);
      }
    },
    error: function(error) {
      console.error(error);
    }
  });
}

//dns-ctndor-knbn buscar

//Actualizar etapa desde kanban
      $("#containerwarrantycards .dns_ctinerclumn").sortable({
        connectWith: ".dns_ctinerclumn",
        placeholder: "task-placeholder",
        receive: function(event, ui) {
          var stage = $(this).attr("id");// -> connectWith
          var cardid = ui.item.attr("id");
          var columnNum = parseInt($(this).find(".dns_nberclumn").text());

            $.ajax({
            url: 'modules/warranty/ajaxjs/updatestage.php',
            type: 'POST',
            dataType: 'json',
            data: {
              stage: stage,
              cardid: cardid
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

//funcion buscar para en kanban 
function SarchTask(sarchtask){
  $.ajax({
    type: "POST",
    url: "modules/warranty/ajaxjs/reloadkanban.php",
    data: {sarchtask: sarchtask },
    dataType: 'json',
    success: function(response){
      $('#containerwarrantycards').html(response.html);
//Actualizar tarea
    $("#containerwarrantycards .dns_ctinerclumn").sortable({
      connectWith: ".dns_ctinerclumn",
      placeholder: "task-placeholder",
      receive: function(event, ui) {
        var stage = $(this).attr("id");// -> connectWith
        var cardid = ui.item.attr("id");
        var columnNum = parseInt($(this).find(".dns_nberclumn").text());
          $.ajax({
          url: 'modules/warranty/ajaxjs/updatestage.php',
          type: 'POST',
          dataType: 'json',
          data: {
            stage: stage,
            cardid: cardid
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

  $('#ccodcli').on('input', function() {
    var query = $(this).val();
    if (query === '') {
    $('#searchlistclient').hide(); // Ocultar el contenedor de resultados
    $('#listclient').empty(); // Vaciar la lista de resultados
    $('#validateclient').empty();
    return; // Salir de la función
    }
    if ((query).length > 0 ){
      $('#searchlistclient').show();
      //$('#dtctndorltarpsble').text(query) ; 
      SearchClient(query);
      if ((query).length < 8 ){
        $('#validateclient').empty();
      }
    }
  });

  function SearchClient(query) {
    $.ajax({
      type: 'POST',
      url: 'modules/warranty/ajaxjs/searchclient.php',
      data: { query: query },
      dataType: 'JSON',
      success: function(response) {
        if(response.status){
          $('#searchlistclient').show();
          $('#listclient').html(response.resulthtml);
        }
        else{
          $('#validateclient').html('<div class="dns_gb_danger dns_clr_success dns_txt_success fw-bold text-center p-2 w-100"> Número de identidad '+query+' no localizado, por favor registre al cliente.</div>');
          $('#ccodcli').addClass('dns_border_danger');
          $('#searchlistclient').hide();
          $('#listclient').empty();

        }
      }
    });
  }

$('#listclient').on('click', '.dns_data', function() {
  var query = $(this).text();
    var datarazon = $(this).find('.dns_datarazon').text();
    var datacode = $(this).find('.dns_datacode').text();
    $('#ccodcli').val(datacode);
    //datacode = datacode;
    $('#validateclient').html('<div class="dns_gb_success dns_clr_success dns_txt_success fw-bold text-center p-2 w-100"> Cliente localizado: '+datarazon+' con número de identidad: '+datacode+'</div>');
    $('#ccodcli').addClass('dns_border_success');
    $('#searchlistclient').hide();
    $('#listclient').empty();
});
$('#ccodcli').keydown(function(e) {
  var $resultados = $('#searchlistclient .dns_data');
  var $resultadoSeleccionado = $('#searchlistclient .dns_data.selected');
  var index = $resultados.index($resultadoSeleccionado);

    if (e.keyCode === 40) { // Flecha abajo
        if (index === $resultados.length - 1) {

            $resultadoSeleccionado.removeClass('selected');
            $resultados.eq(0).addClass('selected');

            $('#listclient').scrollTop(0);
        } else {
            $resultadoSeleccionado.removeClass('selected');
            $resultados.eq(index + 1).addClass('selected');

            var containerHeight = $('#listclient').height();
            var itemHeight = $resultados.eq(index + 1).outerHeight(true);
            var scrollTo = (index + 1) * itemHeight;
            $('#listclient').scrollTop(scrollTo);
        }
    } else if (e.keyCode === 38) { // Flecha arriba
        if (index === 0) {

            $resultadoSeleccionado.removeClass('selected');
            $resultados.eq($resultados.length - 1).addClass('selected');

            $('#listclient').scrollTop($('#listclient')[0].scrollHeight);
        } else {
            $resultadoSeleccionado.removeClass('selected');
            $resultados.eq(index - 1).addClass('selected');

            var itemHeight = $resultados.eq(index - 1).outerHeight(true);
            var scrollTo = (index - 1) * itemHeight;
            $('#listclient').scrollTop(scrollTo);
        }
    } else if (e.keyCode === 13) { // Enter
      var datarazon = $('#searchlistclient .dns_data.selected .dns_datarazon').text();
      var datacode = $('#searchlistclient .dns_data.selected .dns_datacode').text();
      $('#validateclient').html('<div class="dns_gb_success dns_clr_success dns_txt_success fw-bold text-center p-2 w-100"> Cliente localizado: '+datarazon+' con número de identidad: '+datacode+'</div>');
      $('#ccodcli').addClass('dns_border_success');
      $('#ccodcli').val(datacode);
      //dtcdeuser = dtecdgo.text();
      $('#searchlistclient').hide();
      $('#listclient').empty();
    }
  });

  $('#codigo').on('input', function() {
    var query = $(this).val();
    if (query === '') {
    $('#searchlistcodigo').hide(); // Ocultar el contenedor de resultados
    $('#listcodigo').empty(); // Vaciar la lista de resultados
    return; // Salir de la función
    }
    if ((query).length > 0 ){
      $('#searchlistcodigo').show();
      //$('#dtctndorltarpsble').text(query) ; 
      SearchCodigo(query);
    }
  });
  function SearchCodigo(query) {
    $.ajax({
      type: 'POST',
      url: 'modules/warranty/ajaxjs/searchcodigo.php',
      data: { query: query },
      success: function(data) {
        if(data.trim() === 'Sin resultados'){
          $('#searchlistcodigo').hide();
          $('#listcodigo').empty(data);
        } else if (query === '') {
          $('#searchlistcodigo').hide();
          $('#listcodigo').empty(data);
        } else {
          $('#searchlistcodigo').show();
          $('#listcodigo').html(data);
        }
      }
    });
  }
  $('#listcodigo').on('click', '.dns_data', function() {
      var query = $(this).text();
      $('#codigo').val($(this).find('.dns_datacodigo').text());
      $('#descripcion').val($(this).find('.dns_datadescripcion').text());
      $('#categoria').val($(this).find('.dns_datacategoria').text());
      $('#subcategoria').val($(this).find('.dns_datasubcategoria').text());
      $('#marca').val($(this).find('.dns_datamarca').text());
      $('#searchlistcodigo').hide();
      $('#listcodigo').empty();
  });
  $('#codigo').keydown(function(e) {
    var $resultados = $('#searchlistcodigo .dns_data');
    var $resultadoSeleccionado = $('#searchlistcodigo .dns_data.selected');
    var index = $resultados.index($resultadoSeleccionado);

      if (e.keyCode === 40) { // Flecha abajo
          if (index === $resultados.length - 1) {

              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq(0).addClass('selected');

              $('#listcodigo').scrollTop(0);
          } else {
              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq(index + 1).addClass('selected');

              var containerHeight = $('#listcodigo').height();
              var itemHeight = $resultados.eq(index + 1).outerHeight(true);
              var scrollTo = (index + 1) * itemHeight;
              $('#listcodigo').scrollTop(scrollTo);
          }
      } else if (e.keyCode === 38) { // Flecha arriba
          if (index === 0) {

              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq($resultados.length - 1).addClass('selected');

              $('#listcodigo').scrollTop($('#listcodigo')[0].scrollHeight);
          } else {
              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq(index - 1).addClass('selected');

              var itemHeight = $resultados.eq(index - 1).outerHeight(true);
              var scrollTo = (index - 1) * itemHeight;
              $('#listcodigo').scrollTop(scrollTo);
          }
      } else if (e.keyCode === 13) { // Enter
        //var datarazon = $('#searchlistcodigo .dns_data.selected .dns_datarazon');
        $('#codigo').val($('#searchlistcodigo .dns_data.selected .dns_datacodigo').text());
        $('#descripcion').val($('#searchlistcodigo .dns_data.selected .dns_datadescripcion').text());
        $('#categoria').val($('#searchlistcodigo .dns_data.selected .dns_datacategoria').text());
        $('#subcategoria').val($('#searchlistcodigo .dns_data.selected .dns_datasubcategoria').text());
        $('#marca').val($('#searchlistcodigo .dns_data.selected .dns_datamarca').text());
        //dtcdeuser = dtecdgo.text();
        $('#searchlistcodigo').hide();
        $('#listcodigo').empty();
      }
  });


  $('#descripcion').on('input', function() {
    var query = $(this).val();
    if (query === '') {
    $('#searchlistdescripcion').hide(); // Ocultar el contenedor de resultados
    $('#listdescripcion').empty(); // Vaciar la lista de resultados
    return; // Salir de la función
    }
    if ((query).length > 0 ){
      $('#searchlistdescripcion').show();
      //$('#dtctndorltarpsble').text(query) ; 
      SearchDescripcion(query);
    }
  });


  function SearchDescripcion(query) {
    $.ajax({
      type: 'POST',
      url: 'modules/warranty/ajaxjs/searchdescripcion.php',
      data: { query: query },
      success: function(data) {
        if(data.trim() === 'Sin resultados'){
          $('#searchlistdescripcion').hide();
          $('#listdescripcion').empty(data);
        } else if (query === '') {
          $('#searchlistdescripcion').hide();
          $('#listdescripcion').empty(data);
        } else {
          $('#searchlistdescripcion').show();
          $('#listdescripcion').html(data);
        }
      }
    });
  }
  $('#listdescripcion').on('click', '.dns_data', function() {
    var query = $(this).text();
      $('#codigo').val($(this).find('.dns_datacodigo').text());
      $('#descripcion').val($(this).find('.dns_datadescripcion').text());
      $('#categoria').val($(this).find('.dns_datacategoria').text());
      $('#subcategoria').val($(this).find('.dns_datasubcategoria').text());
      $('#marca').val($(this).find('.dns_datamarca').text());
      $('#searchlistdescripcion').hide();
      $('#listdescripcion').empty();
  });
  $('#descripcion').keydown(function(e) {
    var $resultados = $('#searchlistdescripcion .dns_data');
    var $resultadoSeleccionado = $('#searchlistdescripcion .dns_data.selected');
    var index = $resultados.index($resultadoSeleccionado);

      if (e.keyCode === 40) { // Flecha abajo
          if (index === $resultados.length - 1) {

              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq(0).addClass('selected');

              $('#listdescripcion').scrollTop(0);
          } else {
              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq(index + 1).addClass('selected');

              var containerHeight = $('#listdescripcion').height();
              var itemHeight = $resultados.eq(index + 1).outerHeight(true);
              var scrollTo = (index + 1) * itemHeight;
              $('#listdescripcion').scrollTop(scrollTo);
          }
      } else if (e.keyCode === 38) { // Flecha arriba
          if (index === 0) {

              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq($resultados.length - 1).addClass('selected');

              $('#listdescripcion').scrollTop($('#listdescripcion')[0].scrollHeight);
          } else {
              $resultadoSeleccionado.removeClass('selected');
              $resultados.eq(index - 1).addClass('selected');

              var itemHeight = $resultados.eq(index - 1).outerHeight(true);
              var scrollTo = (index - 1) * itemHeight;
              $('#listdescripcion').scrollTop(scrollTo);
          }
      } else if (e.keyCode === 13) { // Enter
        $('#codigo').val($('#searchlistdescripcion .dns_data.selected .dns_datacodigo').text());
        $('#descripcion').val($('#searchlistdescripcion .dns_data.selected .dns_datadescripcion').text());
        $('#categoria').val($('#searchlistdescripcion .dns_data.selected .dns_datacategoria').text());
        $('#subcategoria').val($('#searchlistdescripcion .dns_data.selected .dns_datasubcategoria').text());
        $('#marca').val($('#searchlistdescripcion .dns_data.selected .dns_datamarca').text());
        $('#searchlistdescripcion').hide();
        $('#listdescripcion').empty();
      }
  });

  // $('#ccodcli').keypress(function(event) {
  //   if (event.which === 13) {
  //     alert('Enter key pressed!');
  //   }
  // });

  $("#button_openmodalinsert").click(function() {
    $('<div id="backgroundmodalinsert" class="dns_backgroundmodal"></div>').insertBefore('#containermodalinsert').fadeIn();
    $("#containermodalinsert").toggleClass("open");
  });

  $("#button_closemodalinsert").click(function() {
    $('#backgroundmodalinsert').fadeOut('slow', function() { $(this).remove(); });
    $("#containermodalinsert").toggleClass("open");
  });
  $("#close_w").click(function() {
    $('#backgroundmodalinsert').fadeOut('slow', function() { $(this).remove(); });
    $("#containermodalinsert").toggleClass("open");
  });
  $("#btn_openmodalrazon").click(function() {
    $('<div id="backgroundmodalrazon" class="dns_backgroundmodal"></div>').insertBefore('#containermodalinsert').fadeIn();
    $("#containermodalrazon").toggleClass("open");
    $('#cdni').val($('#ccodcli').val());
  });

$('input').on('input', function() {
  if($(this).val().length < 2){
    $(this).removeClass('dns_border_success');
    $(this).addClass('dns_border_danger');
  } else {
    $(this).removeClass('dns_border_danger');
    $(this).addClass('dns_border_success');
  }
});

$('#containermodalcarddetails').on( 'click', '#update_services_w',function(){
  $.ajax({
    type: "POST",
    url: "modules/warranty/ajaxjs/update_service_w.php",
    data: { wguidenumber: wguidenumber,
            waccessories: $('#dwaccessories').val(),
            wprpc: $('#dwprpc').val(),
            wequipmentstatus: $('#dwequipmentstatus').val(),
            wdiagnostic: $('#dwdiagnostic').val(),
            wproblemsdetected: $('#dwproblemsdetected').val(),
            wconcludingremarks: $('#dwconcludingremarks').val()
     },
    dataType: "JSON",
    success: function(response){
      alert(response.message);
    },
    erro: function(error){

    }
  });
  //alert('funciona');
});


  $("#button_closemodalrazon").click(function() {
    $('#containermodalinsert').prev('.dns_backgroundmodal').fadeOut('slow', function() { $(this).remove(); });
    $("#containermodalrazon").toggleClass("open");
    cleanmodalclient();
  });

  $("#container_formrazon").on('click','#register_companies', function() {
    $.ajax({
      type: "POST",
      url: "modules/client/js_actions.php",
      dataType:"JSON",
      data: { typeregister: 'companies', ccodcli: $('#cdni').val() },
      success: function(responde) {
        $('#container_formrazon').hide().html(responde.resulthtml).fadeIn();
      },
      error: function(error){
      }
    });
  });

  $("#container_formrazon").on('click','#register_client', function() {
    $.ajax({
      type: "POST",
      url: "modules/client/js_actions.php",
      dataType:"JSON",
      data: { typeregister: 'clients', ccodcli: $('#cruc').val() },
      success: function(responde) {
        $('#container_formrazon').hide().html(responde.resulthtml).fadeIn();
      },
      error: function(error){
      }
    });
  });

  $("#container_formrazon").on('click','#saveclient', function() {
    Ccodcli = $('#cdni').val();
    crazon = '';
    Typeregister = 'saveclient';
    saverazon(Typeregister, Ccodcli, crazon);
  });
  $("#container_formrazon").on('click','#savecompanie', function() {
    Typeregister = 'savecompanie';
    crazon = $('#crazon').val();
    Ccodcli = $('#cruc').val();
    saverazon(Typeregister, Ccodcli, crazon);
  });

function saverazon(Typeregister, Ccodcli, crazon){
    $.ajax({
      type: "POST",
      url: "modules/client/js_actions.php",
      dataType:"JSON",
      data: { typeregister:Typeregister, ccodcli: Ccodcli, crazon: crazon, cnombre1:$('#cnombre1').val(), cnombre2:$('#cnombre2').val(), cpaterno:$('#cpaterno').val(), cmaterno:$('#cmaterno').val(), cdireccion:$('#cdireccion').val(), ctelefono1:$('#ctelefono1').val(), ctelefono2:$('#ctelefono2').val(), ccorreo:$('#ccorreo').val() },
      success: function(response) {
        if(response.status){
          alert(response.message);
          $('#ccodcli').val(response.ccodcli);
          $('#validateclient').html('<div class="dns_gb_success dns_clr_success dns_txt_success fw-bold text-center p-2 w-100">Cliente localizado: '+response.crazon+' con número de identidad: '+response.ccodcli+'</div>');
          $('#containermodalinsert').prev('.dns_backgroundmodal').fadeOut('slow', function() { $(this).remove(); });
          $("#containermodalrazon").toggleClass("open");
          cleanmodalclient();
        } else {
          alert(response.message);
        }
      },
      error: function(error){

      }
    });
}

function cleanmodalclient(){
  $('#cdni').val('');
  $('#cruc').val('');
  $('#crazon').val('');
  $('#cnombre1').val('');
  $('#cnombre2').val('');
  $('#cpaterno').val('');
  $('#cmaterno').val('');
  $('#cdireccion').val('');
  $('#ctelefono1').val('');
  $('#ctelefono2').val('');
  $('#ccorreo').val('');
}

$('#container_formrazon').on('click', '#searchrazon', function() {
  $('#loadbgloading').prepend('<div class="dns_bgloading"><i class="bx bx-loader-circle bx-spin bx-rotate-90" ></i></div>');
  $.ajax({
    type: 'POST',
    url: 'modules/client/js_searchrazon.php',
    data:{ Typesearch: 'dni', ccodcli: $('#cdni').val()},
    dataType: 'JSON',
    success: function(response){
            $("#cnombre1").val(response.nombre1);
            $("#cnombre2").val(response.nombre2);
            $("#cpaterno").val(response.apellidoPaterno);
            $("#cmaterno").val(response.apellidoMaterno);
            $('.dns_bgloading').remove();
    },
    error: function(error){

    }
  });
});
$('#container_formrazon').on('click', '#searchruc', function() {
  $('#loadbgloading').prepend('<div class="dns_bgloading"><i class="bx bx-loader-circle bx-spin bx-rotate-90" ></i></div>');
  $.ajax({
    type: 'POST',
    url: 'modules/client/js_searchrazon.php',
    data:{ Typesearch: 'ruc', ccodcli: $('#cruc').val()},
    dataType: 'JSON',
    success: function(response){
            $("#crazon").val(response.nombre);
            $("#cdireccion").val(response.direccion);
            $('.dns_bgloading').remove();
    },
    error: function(error){

    }
  });
});

var wguidenumber;

//Abre los detalles de las tareas
  $("#button_closemodaldetails").click(function() {
     $('#containermodalcarddetails').prev('.dns_backgroundmodal').fadeOut('slow', function() { $(this).remove(); });
    $("#containermodalcarddetails").toggleClass("open");
  });
  $("#containerwarrantycards").on("dblclick", ".dns_cardkban", function() {
    $.ajax({
      type: "POST",
      url: "modules/warranty/ajaxjs/carddetails.php",
      data: { idtask: $(this).find("#idtask").text()},
      dataType: 'json',
      success: function(response) {
        if (response.sttus) {
          wguidenumber = response.wguidenumber;
          $('#dwepwgn').html(response.wepwgn);
          $('#dstates').html(response.states);
          $('#dccodcli').text(response.ccodcli);
          $('#dcrazon').text(response.crazon);
          $('#dctelefono1').text(response.ctelefono1);
          $('#dctelefono2').text(response.ctelefono2);
          $('#dcdireccion').text(response.cdireccion);
          $('#dcodigo').text(response.codigo);
          $('#ddescripcion').text(response.descripcion);
          $('#dserialnumber').text(response.serialnumber);
          $('#dwpriceproduct').text(response.wpriceproduct);
          $('#dwvoucher').text(response.wvoucher);
          $('#dwaccessories').val(response.waccessories);
          $('#dwprpc').val(response.wprpc);
          $('#dwequipmentstatus').val(response.wequipmentstatus);
          $('#dwdiagnostic').val(response.wdiagnostic);
          $('#dwproblemsdetected').val(response.wproblemsdetected);
          $('#dwconcludingremarks').val(response.wconcludingremarks);
          $('#container_timeline').html(response.timelinelist);
          $("#print_w").attr("href", "pdf_garccon.php?wgn="+response.wguidenumber);
          $("#containermodalcarddetails").toggleClass("open");
          $('<div class="dns_backgroundmodal"></div>').insertBefore('#containermodalcarddetails').fadeIn();
        } else {
          alert(response.message);
        }
      },
      error: function(error) {
        console.error(error);
      }
    });
  });

$('#dstates').on('change', function() {
  $.ajax({
    type: 'POST',
    url: 'modules/warranty/ajaxjs/update_state_w.php',
    data:{ wguidenumber: wguidenumber, wstate: $(this).val() },
    dataType: 'json',
    success: function(response){
      alert(response.message);
      $('#container_timeline').html(response.timelinelist);
    },
    error: function(error){

    }
  });
});


  $('#btndashboardwarranty').on('click', function() {
    $.ajax({
      type: "POST",
      url: "modules/warranty/dashboard.php",

      dataType: 'json',
      success: function(response){
        $('#containerwarrantycards').html(response.html);
      },
      error: function(error){
        console.error(error);
      }
    });
  });

});
//jquery