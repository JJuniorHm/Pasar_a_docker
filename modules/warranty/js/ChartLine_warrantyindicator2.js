$(document).ready(function() {

$("#year").on('change', function() {
  ChartLineDefault();
});

$("#month").on('change', function() {
  ChartLineDefault();
});

ChartLineDefault();

  function ChartLineDefault()
  {
    $.ajax({
      type: "POST",
        url: "modules/warranty/js_chartline_pormes2.php",
        data: { year: $('#year').val(), month: $('#month').val() },
        dataType: 'JSON',
        success: function(response) {
          $('#warrantydetails').html(response.array2.map(item => item));
          updateChart(response); // Actualizar el gráfico con los datos obtenidos
        },
        error: function(error) {
          console.error("Error en la llamada AJAX:", error);
        }
    });
  }
  $(window).on('resize', function() {
    echarts.init($('#chart')[0]).resize();
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

  $('#exportxlsxwarrantry').click(function() {
    var filename = "GC";
    $.ajax({
      type: 'POST',
      url: 'modules/warranty/js_export_xlsx.php',
      data: { filename: filename },
      datatype: "json",
      success: function(response) {
        const nombreArchivo = response;
        const rutaArchivo = response;
        const a = document.createElement('a');
        a.href = rutaArchivo;
        a.download = nombreArchivo;
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        },
        error: function(error) {
          console.error(error);
        }
      });
    });


  
});

function updateChart(response) {
  var data = response.chartdata.map(item => item.datacount);
  var labels = response.chartdata.map(item => item.wentrydate);
  var intervalY = 10;

  var minValue = Math.min(...data) - intervalY;
  var maxValue = Math.ceil(Math.max(...data) / intervalY) * intervalY + intervalY;

  var chartOptions = {
    grid: { left: 25, right: 40, top: 25, bottom: 25 },
    xAxis: {
      type: 'category',
      data: labels,
      boundaryGap: false,
      splitLine: {
        show: true,
        lineStyle: { color: 'rgba(0, 0, 0, 0.1)' }
      }
    },
    yAxis: {
      type: 'value',
      min: minValue,
      max: maxValue,
      interval: intervalY,
      splitLine: {
        show: true,
        lineStyle: { color: 'rgba(0, 0, 0, 0.1)' }
      }
    },
    series: [{
      name: 'Garantias GC',
      type: 'line',
      data: data,
      symbol: 'circle',
      symbolSize: 15,
      itemStyle: { color: 'rgba(58, 87, 232, 1)' },
      smooth: 0.2,
      label: {
        show: false,
        position: 'top',
        formatter: params => params.data === 0 ? '' : ` ${params.data}`
      },
      lineStyle: { width: 3, color: 'rgba(58, 87, 232, 1)' },
      areaStyle: { color: 'rgba(58, 87, 232, 0.3)' },
      emphasis: { focus: 'series' },
      markLine: { data: [{ type: 'average', name: 'Promedio' }] },
      markPoint: {
        data: data.map((value, index) => ({
          value: value,
          xAxis: index,
          yAxis: value,
          label: {
            show: true,
            formatter: value.toString(),
            color: 'white',
            fontWeight: 'bold'
          },
          itemStyle: { color: 'rgba(58, 87, 232, 0.8)' }
        }))
      }
    }]
  };

  var chart = echarts.init($('#chart')[0]);
  chart.setOption(chartOptions);

  // Eliminar oyentes de eventos de clic existentes para evitar duplicados
  chart.off('click');

  // Añadir nuevo oyente de eventos de clic
  chart.on('click', function(params) {
    if (params.componentType === 'markPoint') {
      var label = labels[params.data.xAxis];
      //alert(`Label: ${label}\nValor: ${params.data.value} ${$("#year").val()} ${$("#month").val()}`);
      loadtablewarrantyindicator(label);
    }
  });
}

function loadtablewarrantyindicator(label) {
  $.ajax({
    type: 'POST',
    url: 'modules/warranty/js_table_warranty_indicator.php',
    data:{ year: $('#year').val(), month: $('#month').val() , label: label},
    dataType: 'JSON',
    success: function(response){
      $('#tablewarranty').html(response.html);
      $('#tablewarrantydetails').html(response.tablewarrantydetails);
    },
    error: function(error){

    }
  });
  
}