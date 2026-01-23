<?php

include "../../csses/task/openkbantask.php";

$user = new user();
$infotask = new infotask();

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

$infotask->setNumberId($_POST['idtask']);
$get_infotask = $infotask->getInfoTask();
if($get_infotask)
{
//$user->Set_dttpogrta($get_infotask['stcg_tip_gi']);

//Buscar Linea de tiempo
$get_tmelne = $infotask->getTmeLne();

setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
foreach ($get_tmelne as $key) {
	$fchahra = $key['fchareg'];
	$nombre_mes = strftime("%B", strtotime($fchahra));
	$nombre_mes_mayuscula = ucfirst($nombre_mes);
	$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
	$horaFormateada = date("g:i a", strtotime($fchahra));

	if($key['ttlo'] == "Comentario"){
		$ltacmtros .= '
					<div class="ctndornp my-2 p-2">
					<div class="dns_ctndorcmtrouser">
						<span class="dns_cmtrouser">'.$key['urazon'].'</span><span class="dns_cmtrofchareg">'.$key['fchareg'].'</span>
					</div>
						'.$key['dccon'].'
					</div>';
	}
	switch ($key['ttlo']) {
		case 'Etapa Cambiada':
		$etlodnstlttlo = 'dns-tl-ttlo';
		break;
		case 'Tarea por Hacer':
		$etlodnstlttlo = 'dns-tl-ttlotraphcer';
		break;
		default:
		$etlodnstlttlo = 'dns-tl-ttlo';
		break;
	}
	if($key['ttlo'] == "Etapa Cambiada"){
		$etlodnstlttlo = 'dns-tl-ttlo';
	};
	if($fecha_formateada !== $atrorfcha){
		$ipmirfcha = '<div class="dns-fcha">
							<span>'.$fecha_formateada.'</span>
						</div>';
		$atrorfcha = $fecha_formateada;
	}
	else
	{
		$ipmirfcha='';
	};
	$ltalneatepo .= '
					<div class="dns-ctndorlneatepo">
						'.$ipmirfcha.'
						<div class="dns-dtlneatepo">
							<div class="dns-hader">
								<div class="dns-block1">
									<div class="'.$etlodnstlttlo.'">
										<span>'.$key['ttlo'].'</span>
									</div>
									<div class="dns-tl-fcha">
										<span>'.$horaFormateada.'</span>
									</div>
								</div>
								<div class="dns-block2">
									<img src="imges/cdgopsnal/'.$key['ucoduser'].'.webp">
								</div>
							</div>
							<div class="dns-bdy">
								<span>'.substr(str_replace("&nbsp;", "", strip_tags($key['dccon'])), 0, 150 ).'</span>
							</div>
						</div>
					</div>
					';
	$etlodnstlttlo = null;				
}
if (empty($ltacmtros)) {
    $ltacmtros = '<div class="ctndornp my-2 p-2">Aún no hay Comentarios.</div>';
}

//Buscar Linea de tiempo

	echo json_encode(array('sttus' => true, 'dttnmroid' => $get_infotask['nmroid'], 'dttttlo' => strip_tags($get_infotask['ttlo']), 'dtucador' => ($get_infotask['cunombre1'].' '.$get_infotask['cupaterno']), 'dturpsble' => $get_infotask['runombre1'].' '.$get_infotask['rupaterno'], 'dttfchareg' => $get_infotask['fchareg'], 'dttfchalmte' => $get_infotask['fchalmte'], 'dttetdofchalmte' => $get_infotask['etdofchalmte'], 'dttetdo' => $get_infotask['etdo'], 'dttnvel' => $get_infotask['nvel'], 'dttdccon' => $get_infotask['dccon'], 'dtlneatepo' => $ltalneatepo, 'dttracmtros' => $ltacmtros ));
}
else
{
	echo json_encode(array('sttus' => false, 'message' => 'Datos no encontrados'));
}
?>