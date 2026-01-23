<?php

include "class_indicator.php";

$indicator = new indicator();

$meses = array(
    'Enero' => 1,
    'Febrero' => 2,
    'Marzo' => 3,
    'Abril' => 4,
    'Mayo' => 5,
    'Junio' => 6,
    'Julio' => 7,
    'Agosto' => 8,
    'Septiembre' => 9,
    'Octubre' => 10,
    'Noviembre' => 11,
    'Diciembre' => 12
);

$html = '';
$countwgnentry = 0;
$countwppentry = 0;
$countwgnexit = 0;
$countwppexit = 0;
$countwgnpending = 0;
$countwpppending = 0;
if (array_key_exists($_POST['label'], $meses)) {
    $indicator->setYear($_POST['year']);
    $indicator->setMonth($meses[$_POST['label']]);
	$result = $indicator->GetIndicatorDetailsMonth();
	if($result->num_rows > 0){
	    while ($row = $result->fetch_assoc()) {
	    	$countwgnentry += 1;
	    	$countwppentry += $row['wpriceproduct'];
	    	if( $row['wstage'] == "GESTIÓN DE SALIDA" && $row['wstate'] == "PRODUCTO ENTREGADO" ){
	    		$countwgnexit += 1;
	    		$countwppexit += $row['wpriceproduct'];
	    	}
	    	if( !($row['wstage'] == "GESTIÓN DE SALIDA" && $row['wstate'] == "PRODUCTO ENTREGADO") ){
	    		$countwgnpending += 1;
	    		$countwpppending += $row['wpriceproduct'];
	    	}
			$html .= '
			<tr>
				<td>
					<div >
						<button class="dns_buttondetails">'.$row['wguidenumber'].'</button></td>
					</div>
				<td>
				<div class="text-truncate">
					<span class="dns_st1">COD:</span>&nbsp;<span class="dns_dcc1">'.$row['ccodcli'].'</span>
				<div>
				<div class="text-truncate">
					<span class="dns_st1">Razón:</span>&nbsp;<span class="dns_dcc1 ">'.$row['crazon'].'</span>
				<div>
				<div class="text-truncate">
					<span class="dns_st1">Tel:</span>&nbsp;<span class="dns_dcc1">'.$row['ctelefono1'].' '.(!empty($row['ctelefono2']) ? '/ '.$row['ctelefono2'] : '' ).'</span>
				<div>
				</td>
				<td>'.$row['wstage'].'</td>
				<td>'.(!empty($row['wstate']) ? $row['wstate'] : "AÚN SIN ESTADO" ).'</td>
			</tr>
			';
	    }
	}
} else {
	if($_POST['month'] == "anual"){
	    $indicator->setYear($_POST['year']);
		$result = $indicator->GetIndicatorDetailsYear();
		if($result->num_rows > 0){
		    while ($row = $result->fetch_assoc()) {
		    	$countwgnentry += 1;
		    	$countwppentry += $row['wpriceproduct'];
		    	if( $row['wstage'] == "GESTIÓN DE SALIDA" && $row['wstate'] == "PRODUCTO ENTREGADO" ){
		    		$countwgnexit += 1;
		    		$countwppexit += $row['wpriceproduct'];
		    	}
		    	if( !($row['wstage'] == "GESTIÓN DE SALIDA" && $row['wstate'] == "PRODUCTO ENTREGADO") ){
		    		$countwgnpending += 1;
		    		$countwpppending += $row['wpriceproduct'];
		    	}
				$html .= '
				<tr>
					<td>
						<div >
							<button class="dns_buttondetails">'.$row['wguidenumber'].'</button></td>
						</div>
					<td>
					<div class="text-truncate">
						<span class="dns_st1">COD:</span>&nbsp;<span class="dns_dcc1">'.$row['ccodcli'].'</span>
					<div>
					<div class="text-truncate">
						<span class="dns_st1">Razón:</span>&nbsp;<span class="dns_dcc1 ">'.$row['crazon'].'</span>
					<div>
					<div class="text-truncate">
						<span class="dns_st1">Tel:</span>&nbsp;<span class="dns_dcc1">'.$row['ctelefono1'].' '.(!empty($row['ctelefono2']) ? '/ '.$row['ctelefono2'] : '' ).'</span>
					<div>
					</td>
					<td>'.$row['wstage'].'</td>
					<td>'.(!empty($row['wstate']) ? $row['wstate'] : "AÚN SIN ESTADO" ).'</td>
				</tr>
				';
		    }
		}
	} else {
	    $indicator->setYear($_POST['year']);
	    $indicator->setMonth($_POST['month']);
	    $indicator->setDay($_POST['label']);
		$result = $indicator->GetIndicatorDetailsDay();
		if($result->num_rows > 0){
		    while ($row = $result->fetch_assoc()) {
		    	$countwgnentry += 1;
		    	$countwppentry += $row['wpriceproduct'];
		    	if( $row['wstage'] == "GESTIÓN DE SALIDA" && $row['wstate'] == "PRODUCTO ENTREGADO" ){
		    		$countwgnexit += 1;
		    		$countwppexit += $row['wpriceproduct'];
		    	}
		    	if( !($row['wstage'] == "GESTIÓN DE SALIDA" && $row['wstate'] == "PRODUCTO ENTREGADO") ){
		    		$countwgnpending += 1;
		    		$countwpppending += $row['wpriceproduct'];
		    	}
				$html .= '
				<tr>
					<td>
						<div >
							<button class="dns_buttondetails">'.$row['wguidenumber'].'</button></td>
						</div>
					<td>
					<div class="text-truncate">
						<span class="dns_st1">COD:</span>&nbsp;<span class="dns_dcc1">'.$row['ccodcli'].'</span>
					<div>
					<div class="text-truncate">
						<span class="dns_st1">Razón:</span>&nbsp;<span class="dns_dcc1 ">'.$row['crazon'].'</span>
					<div>
					<div class="text-truncate">
						<span class="dns_st1">Tel:</span>&nbsp;<span class="dns_dcc1">'.$row['ctelefono1'].' '.(!empty($row['ctelefono2']) ? '/ '.$row['ctelefono2'] : '' ).'</span>
					<div>
					</td>
					<td>'.$row['wstage'].'</td>
					<td>'.(!empty($row['wstate']) ? $row['wstate'] : "AÚN SIN ESTADO" ).'</td>
				</tr>
				';
		    }
		}
	}
} 

$tablewarrantydetails = '
<div class="row g-2">
	<div class="col-5">
	    <div class="card dns_df-jc-jaic dns_b2-bc-warning dns_shadow1 p-2 h-100">
	        <h5>'.$countwgnentry.'</h5>
	        <span class="dns_st1">Internados</span>
	    </div>
    </div>
    <div class="col-7">
	    <div class="card dns_df-jc-jaic dns_b2-bc-warning dns_shadow1 p-2">
	        <h5>S/'.number_format($countwppentry, 2).'</h5>
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
	        <h5>S/'.number_format($countwppexit, 2).'</h5>
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
	        <h5>S/'.number_format($countwpppending, 2).'</h5>
	        <span class="dns_st1">Valorización de Pendientes</span>
	    </div>
    </div>
</div>
';


header("Content-Type: application/json");

echo json_encode(array('html' => $html,  'tablewarrantydetails' => $tablewarrantydetails ));
?>