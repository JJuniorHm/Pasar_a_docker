<?php
include "class_indicator.php";

$user = new user();
$indicator = new indicator();

$result = $indicator->GetIndicator();

if (!empty($_SESSION['ucoduser'])) {
    $coduser = $_SESSION['ucoduser'];
}

if ($user->getSession() === FALSE) {
    header("location:lgn.php");
}

if (isset($_GET['q'])) {
    $user->logout();
    header("location:lgn.php");
}

$mesActual = date('m');

// =========================
// AÑOS DINÁMICOS
// =========================
$yearNow = date("Y");
$yearOptions = "";

for ($y = 2023; $y <= $yearNow; $y++) {
    $selected = ($y == $yearNow) ? "selected" : "";
    $yearOptions .= "<option value='$y' $selected>$y</option>";
}

// =========================
// LISTA DE MESES
// =========================
$meses = [
    1 => "Enero",
    2 => "Febrero",
    3 => "Marzo",
    4 => "Abril",
    5 => "Mayo",
    6 => "Junio",
    7 => "Julio",
    8 => "Agosto",
    9 => "Septiembre",
    10 => "Octubre",
    11 => "Noviembre",
    12 => "Diciembre"
];

$listameses = "";

foreach ($meses as $numero => $nombre) {
    $listameses .= '<option value="'. $numero .'" '.(($numero == $mesActual) ? "selected" : "").'>'. $nombre .'</option>';
}

// =========================
// HTML DEL DASHBOARD
// =========================
$searchResultHTML = '
<nav class="dns_navbar dns_br10 dns_shadow1 my-2">
    <div class="container-fluid">
        <div class="dns_df-jc-jaic22">
            <div class="row col-6">
                <div class="col-6 col-lg-4">
                    <select id="year" class="dns_forminput">
                        '.$yearOptions.'
                    </select>
                </div>

                <div class="col-6 col-lg-4">
                    <select id="month" class="dns_forminput">
                        '.$listameses.'
                    </select>
                </div>
            </div>

            <div class="row">
                <button id="exportxlsxwarrantry" class="dns_buttonfilexlxs dns_shadow1">
                    <i class="bx bxs-file-export"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<div class="row g-2">
    <div class="col-12">
        <div class="card dns_br10 dns_shadow1">
            <div class="card-header">
                Gráfico de Lineas
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="splineChart">
                            <div id="chart" class="h-100"></div>
                        </div>
                    </div>

                    <div id="warrantydetails" class="col-lg-4"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card dns_br10 dns_shadow1">
            <div class="card-header">
                Guías de Internamiento
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">&nbsp;Cliente</th>
                                    <th scope="col">Etapa&nbsp;</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>

                            <tbody id="tablewarranty" class="table-wrapper">
                                <tr>
                                    <td>Sin datos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="tablewarrantydetails" class="col-lg-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/5.0.2_echarts.min.js"></script>
<script src="modules/warranty/js/ChartLine_warrantyindicator2.js"></script>
';

echo json_encode([
    "html" => $searchResultHTML
]);
?>
