// =========================
// FECHA ACTUAL (LIMA)
// =========================
var Znahrria = new Date().toLocaleString("en-US", { timeZone: "America/Lima" });
var FchaAtal = new Date(Znahrria);

var MesAtal = FchaAtal.getMonth() + 1;
var AnoAtal = FchaAtal.getFullYear();


$(document).ready(function() {

$('#listresponsible').on('change', function() {
  ChartLineResponsible();
});

$('#list_year').on('change', function() {
  $.ajax({
    type: "POST",
    url: "ajaxjs/task/chartline_selectors.php",
    data:{ action: "listmonths", selectyear: $(this).val()},
    
    success: function(response){
      $('#list_month').html(response);
    },
    error: function(error){
      console.log();
    }
  });
});
$('#list_month').on('change', function() {
  $.ajax({
    type: "POST",
    url: "ajaxjs/task/chartline_selectors.php",
    data:{ action: "listresponsible", selectyear: $('#list_year').val(), selectmonth: $(this).val()},
    
    success: function(response){
      $('#listresponsible').html(response);
    },
    error: function(error){
      console.log();
    }
  });
});

ChartLineDefault();

  function ChartLineResponsible()
  {
    $.ajax({
      type: "POST",
      url: "ajaxjs/task/gc_chartline_pormes2.php",
      dataType: "json",
      data: { 
        listresponsible: $('#listresponsible').val(),
        slcnaraño: $('#list_year').val(),
        slcnarmes: $('#list_month').val()
      },
      success: function(response) {
        console.log("RESPONSABLE:", response);
        updateChart(response);
      },
      error: function(error) {
        console.error("Error AJAX:", error);
      }
    });
  }


  function ChartLineDefault()
{
  const params = { 
    slcnaraño: AnoAtal,
    slcnarmes: MesAtal
  };
  const resp =$('#listresponsible').val();
  if(resp && resp!= "") {
    params.listresponsible = resp;
  }

  console.log("DEFAULT PARAMS:", params);

  $.ajax({
    type: "POST",
    url: "ajaxjs/task/gc_chartline_pormes2.php",
    dataType: "json",
    data: params,
    success: function(response) {
      console.log("DEFAULT RESPONSE:", response);
      updateChart(response);
    },
    error: function(error) {
      console.error("Error AJAX:", error);
    }
  });
}
      $(window).on('resize', function() {
        echarts.init($('#gfcolnalgc')[0]).resize();
      });
});


function updateChart(response) {

  if (!response || !Array.isArray(response.data)) {
    console.warn("Formato inesperado:", response);
    return;
  }

  var data = response.data.map(item => item.efcecy);
  var labels = response.data.map(item => item.dtergter);

  // si no hay datos
  if (data.length === 0) {
    console.warn("Sin datos para graficar");
    echarts.init($('#gfcolnalgc')[0]).clear();
    return;
  }

  var itervalY = 10;
  var minValue = Math.min(...data) - itervalY;

  var option = {
    grid: { left: 25, right: 40, top: 25, bottom: 25 },
    xAxis: {
      type: 'category',
      data: labels,
      boundaryGap: false,
      splitLine: { show: true }
    },
    yAxis: {
      type: 'value',
      min: minValue,
      max: Math.ceil(Math.max(...data) / itervalY) * itervalY + itervalY,
      interval: itervalY
    },
    series: [
      {
        name: 'Garantias GC',
        type: 'line',
        data: data,
        smooth: 0.2
      }
    ]
  };

  echarts.init($('#gfcolnalgc')[0]).setOption(option);
}
