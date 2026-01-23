<?php

include "class_indicator.php";

$indicator = new indicator();

$indicator->SetYear($_POST['year']);
$indicator->SetMonth($_POST['month']);


$chartdata = array();
$countwgn = 0;
$sumwpp = 0;
$countwgnexit = 0;
$sumwppexit = 0;
$countwgnpending = 0;
$sumwpppending = 0;
if($_POST['month'] === "anual"){
	$result = $indicator->GetIndicatorYearly();
	if ($result->num_rows > 0) {
		$COUNTwgnSUMwppMonth = $indicator->GetCOUNTwgnSUMwppYear();
		$countwgn = $COUNTwgnSUMwppMonth['countwgn'];
		$sumwpp = $COUNTwgnSUMwppMonth['sumwpp'];
		$COUNTwgnExitY = $indicator->GetCOUNTwgnExitY();
		$countwgnexit = $COUNTwgnExitY['countwgnexit'];
		$sumwppexit = $COUNTwgnExitY['sumwppexit'];
		$COUNTwgnPendingY = $indicator->GetCOUNTwgnPendingY();
		$countwgnpending = $COUNTwgnPendingY['countwgnpending'];
		$sumwpppending = $COUNTwgnPendingY['sumwpppending'];
	    $months = array(
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
	    );
	    while ($row = $result->fetch_assoc()) {
	    	$monthName = $months[(int)$row["month"]];
	        $chartdata[] = array(
	            "wentrydate" => $monthName,
	            "datacount" => $row["countguidenumber"]
	        );
	    }
	} else {
	    $chartdata[] = array(
	        "wentrydate" => "No data",
	        "datacount" => 0
	    );
	}

} else {
	$result = $indicator->GetIndicator();
	if ($result->num_rows > 0) {
		$COUNTwgnSUMwppMonth = $indicator->GetCOUNTwgnSUMwppMonth();
		$countwgn = $COUNTwgnSUMwppMonth['countwgn'];
		$sumwpp = $COUNTwgnSUMwppMonth['sumwpp'];
		$COUNTwgnExitYM = $indicator->GetCOUNTwgnExitYM();
		$countwgnexit = $COUNTwgnExitYM['countwgnexit'];
		$sumwppexit = $COUNTwgnExitYM['sumwppexit'];
		$COUNTwgnPendingYM = $indicator->GetCOUNTwgnPendingYM();
		$countwgnpending = $COUNTwgnPendingYM['countwgnpending'];
		$sumwpppending = $COUNTwgnPendingYM['sumwpppending'];
	    while ($row = $result->fetch_assoc()) {
	        $chartdata[] = array(
	            "wentrydate" => $row["day"],
	            "datacount" => $row["countguidenumber"]
	        );
	    }
	} else {
	    $chartdata[] = array(
	        "wentrydate" => "No data",
	        "datacount" => 0
	    );
	}
}

$htmldetails = array('
<div class="row g-2">
	<div class="col-5">
	    <div class="card dns_df-jc-jaic dns_b2-bc-warning dns_shadow1 p-2 h-100">
	        <h5>'.$countwgn.'</h5>
	        <span class="dns_st1">Internados</span>
	    </div>
    </div>
    <div class="col-7">
	    <div class="card dns_df-jc-jaic dns_b2-bc-warning dns_shadow1 p-2">
	        <h5>S/'.number_format($sumwpp, 2).'</h5>
	        <span class="dns_st1">Valorización de Internados</span>
	    </div>
    </div>
	<div class="col-5">
	    <div class="card dns_df-jc-jaic dns_b2-bc-success dns_shadow1 p-2 h-100">
	        <h5>'.$countwgnexit.'</h5>
	        <span class="dns_st1">Entregados</span>
	    </div>
    </div>
    <div class="col-7">
	    <div class="card dns_df-jc-jaic dns_b2-bc-success dns_shadow1 p-2">
	        <h5>S/'.number_format($sumwppexit, 2).'</h5>
	        <span class="dns_st1">Valorización de Entregados</span>
	    </div>
    </div>
	<div class="col-5">
	    <div class="card dns_df-jc-jaic dns_b2-bc-danger dns_shadow1 p-2 h-100">
	        <h5>'.$countwgnpending.'</h5>
	        <span class="dns_st1">Pendientes</span>
	    </div>
    </div>
    <div class="col-7">
	    <div class="card dns_df-jc-jaic dns_b2-bc-danger dns_shadow1 p-2">
	        <h5>S/'.number_format($sumwpppending, 2).'</h5>
	        <span class="dns_st1">Valorización de Pendientes</span>
	    </div>
    </div>
</div>
');

// Cerrar la conexión a la base de datos
$jsonData = array(
    "chartdata" => $chartdata,
    "array2" => $htmldetails,
);


header("Content-Type: application/json");
echo json_encode($jsonData);
?>