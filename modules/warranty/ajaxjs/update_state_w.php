<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

include "../../../modules/warranty/classes/update_state_w.php";
$user = new user();
$update_state_w = new update_state_w();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();
 
$atrorfcha = null;
$ltalneatepo = null;

$update_state_w->SetUCodUser($userInfo['ucoduser']);
$update_state_w->SetWGuideNumber($_POST['wguidenumber']);
$update_state_w->SetWState($_POST['wstate']);
$check_update_state_w = $update_state_w->update_state_w();

if($check_update_state_w){
	//Buscar Linea de tiempo
	$get_tmelne = $update_state_w->GetTimeLine();

}
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

// Codificamos el array completo
echo json_encode(array('sttus' => true,
	                   'message' => $_POST['wguidenumber'] .' '.$_POST['wstate'],
                       'timelinelist' => $ltalneatepo));
 
}
?>
