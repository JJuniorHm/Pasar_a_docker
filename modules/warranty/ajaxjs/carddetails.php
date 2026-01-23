<?php

include "../../../modules/warranty/classes/carddetails.php";

$user = new user();
$carddetails = new carddetails();

$status = '';
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

$ltalneatepo = null;
$ltacmtros = null;
$atrorfcha = null;
$ipmirfcha = null;
$etlodnstlttlo = null;

$carddetails->SetWGuideNumber($_POST['idtask']);
$GetCardDetails = $carddetails->GetCardDetails();
if($GetCardDetails)
{
//$user->Set_dttpogrta($get_infotask['stcg_tip_gi']);

//Buscar Linea de tiempo
$get_tmelne = $carddetails->GetTimeLine();
$states = '';
// 
if($GetCardDetails['wstage'] == "GESTIÓN DE INTERNAMIENTO"){
	$states = '
		<option value="" ></option>
		<option value="DIAGNÓSTICO" '.($GetCardDetails['wstate'] == "DIAGNÓSTICO" ? "selected" : "" ).'>DIAGNÓSTICO</option>
		<option value="NOTIFICAR AL CLIENTE" '.($GetCardDetails['wstate'] == "NOTIFICAR AL CLIENTE" ? "selected" : "" ).'>NOTIFICAR AL CLIENTE</option>
	';
}
// GESTION DE ENVIO AL PROVEEDOR
if($GetCardDetails['wstage'] == "GESTIÓN DE ENVÍO: PROVEEDOR"){
	$states = '
		<option value="" ></option>
		<option value="DERIVAR AL PROVEEDOR" '.($GetCardDetails['wstate'] == "DERIVAR AL PROVEEDOR" ? "selected" : "" ).'>DERIVAR AL PROVEEDOR</option>
		<option value="CONFIRMAR RECEPCIÓN" '.($GetCardDetails['wstate'] == "CONFIRMAR RECEPCIÓN" ? "selected" : "" ).'>CONFIRMAR RECEPCIÓN</option>
		<option value="CONSULTAR ESTADO DE GARANTÍA" '.($GetCardDetails['wstate'] == "CONSULTAR ESTADO DE GARANTÍA" ? "selected" : "" ).'>CONSULTAR ESTADO DE GARANTÍA</option>
		<option value="NOTIFICAR AL CLIENTE: CONFIRMAR GARANTÍA" '.($GetCardDetails['wstate'] == "NOTIFICAR AL CLIENTE: CONFIRMAR GARANTÍA" ? "selected" : "" ).'>NOTIFICAR AL CLIENTE: CONFIRMAR GARANTÍA</option>
	';
}
// VALIDAR RETORNO
if($GetCardDetails['wstage'] == "GESTIÓN DE RETORNO: PROVEEDOR"){
	$states = '
		<option value="" ></option>
		<option value="DIAGNÓSTICO" '.($GetCardDetails['wstate'] == "DIAGNÓSTICO" ? "selected" : "" ).'>DIAGNÓSTICO</option>
		<option value="RETORNO AL PROVEEDOR" '.($GetCardDetails['wstate'] == "RETORNO AL PROVEEDOR" ? "selected" : "" ).'>RETORNO AL PROVEEDOR</option>
		<option value="NOTIFICAR AL CLIENTE: RECOJO O REINGRESO" '.($GetCardDetails['wstate'] == "NOTIFICAR AL CLIENTE: RECOJO O REINGRESO" ? "selected" : "" ).'>NOTIFICAR AL CLIENTE: RECOJO O REINGRESO</option>
	';
}
// Posiblemente cambiar el nombre a Gestión de entrega
if($GetCardDetails['wstage'] == "GESTIÓN DE SALIDA"){
	$states = '
		<option value="" ></option>
		<option value="TRANSFERENCIA A ALMACEN" '.($GetCardDetails['wstate'] == "TRANSFERENCIA A ALMACEN" ? "selected" : "" ).'>TRANSFERENCIA A ALMACEN</option>
		<option value="GARANTÍA VALIDADA" '.($GetCardDetails['wstate'] == "GARANTÍA VALIDADA" ? "selected" : "" ).'>GARANTÍA VALIDADA</option>
		<option value="GARANTÍA INVALIDADA" '.($GetCardDetails['wstate'] == "GARANTÍA INVALIDADA" ? "selected" : "" ).'>GARANTÍA INVALIDADA</option>
		<option value="NOTIFICAR AL CLIENTE" '.($GetCardDetails['wstate'] == "NOTIFICAR AL CLIENTE" ? "selected" : "" ).'>NOTIFICAR AL CLIENTE</option>
		<option value="PRODUCTO ENTREGADO" '.($GetCardDetails['wstate'] == "PRODUCTO ENTREGADO" ? "selected" : "" ).'>PRODUCTO ENTREGADO</option>
	';
}


setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
foreach ($get_tmelne as $key) {
	$fchahra = $key['wtl_entrydate'];
	$nombre_mes = strftime("%B", strtotime($fchahra));
	$nombre_mes_mayuscula = ucfirst($nombre_mes);
	$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
	$horaFormateada = date("g:i a", strtotime($fchahra));
 
	switch ($key['wtl_title']) {
		case 'Etapa Cambiada':
		$etlodnstlttlo = 'dns-tl-ttlo';
		break;
		case 'Estado Cambiado':
		$etlodnstlttlo = 'dns-tl-ttlotraphcer';
		break;
		default:
		$etlodnstlttlo = 'dns-tl-ttlo';
		break;
	}
	if($fecha_formateada !== $atrorfcha){
		$ipmirfcha = '<div class="dns_date">
							<span>'.$fecha_formateada.'</span>
						</div>';
		$atrorfcha = $fecha_formateada;
	}
	else
	{
		$ipmirfcha='';
	};
	$ltalneatepo .= '
					<div class="dns_container_timeline">
						'.$ipmirfcha.'
						<div class="dns_content_timeline">
							<div class="dns_header">
								<div class="dns_block1">
									<div class="'.$etlodnstlttlo.'">
										<span>'.$key['wtl_title'].'</span>
									</div>
									<div class="dns-tl-fcha">
										<span>'.$horaFormateada.'</span>
									</div>
								</div>
								<div class="dns_block2">
									<img src="imges/cdgopsnal/'.$key['ucoduser'].'.webp">
								</div>
							</div>
							<div class="dns_body">
								<span>'.substr(str_replace("&nbsp;", "", strip_tags($key['wtl_description'])), 0, 150 ).'</span>
							</div>
						</div>
					</div>
					';
	$etlodnstlttlo = null;				
}
if (empty($ltalneatepo)) {
    $ltalneatepo = '<div class="ctndornp my-2 p-2">Aún no hay cambios en el documento.</div>';
}

//Buscar Linea de tiempo

	echo json_encode(array('sttus' => true,
						  	'wepwgn' => $GetCardDetails["wendpoint"].'-'.str_pad($GetCardDetails["wguidenumber"], 8, '0', STR_PAD_LEFT),
						  	'wguidenumber' => $GetCardDetails["wguidenumber"],
		                	'states' => $states,
		                 	'ccodcli' => $GetCardDetails['ccodcli'],
		                	'crazon' => $GetCardDetails['crazon'],
		                	'ctelefono1' => $GetCardDetails['ctelefono1'],
		                	'ctelefono2' => $GetCardDetails['ctelefono2'],
		                	'cdireccion' => $GetCardDetails['cdireccion'],
		                	'codigo' => $GetCardDetails['codigo'],
		                	'descripcion' => $GetCardDetails['descripcion'],
		               		'serialnumber' => $GetCardDetails['serialnumber'],
		                	'wpriceproduct' => $GetCardDetails['wpriceproduct'],
		                	'wvoucher' => $GetCardDetails['wvoucher'],
		                	'wguidenumber' => $GetCardDetails['wguidenumber'],
                            'waccessories' => $GetCardDetails['waccessories'],
                            'wprpc' => $GetCardDetails['wprpc'],
                            'wequipmentstatus' => $GetCardDetails['wequipmentstatus'],
                            'wdiagnostic' => $GetCardDetails['wdiagnostic'],
                            'wproblemsdetected' => $GetCardDetails['wproblemsdetected'],
                            'wconcludingremarks' => $GetCardDetails['wconcludingremarks'],
                            'timelinelist' => $ltalneatepo ));
}
else
{
	echo json_encode(array('sttus' => false, 'message' => 'Datos no encontrados'));
}
?>