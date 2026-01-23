<?php
include "include/class_udtemdaltask.php";

$user = new User();
$udtemdaltask = new udtemdaltask();

$status = '';
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

$ltalneatepo = null;
$atrorfcha = null;
$ipmirfcha = null;
$etlodnstlttlo = null;

$udtemdaltask->setNumberId(str_replace("0", "", $_POST['dttnmroid']));
$check_rgter = $udtemdaltask->CheckRgter();

$dtprivilegios = $udtemdaltask->GetPvlgos();

if( $userInfo['ucoduser'] == $dtprivilegios['cadorid'] && $userInfo['ucoduser'] == $dtprivilegios['rpsbleid'] )
{
	if( $_POST['dtudteetpagarccon'] == "Completado" )
	{
		if($dtcdgoltrasnmros)
		{ 
			$user->setCodUser($userInfo['ucoduser']);
			$user->setdtRpsbleId($dtprivilegios['rpsbleid']);
			$user->setdtEtdo($_POST['dtudteetpagarccon']);
			$user->setdtLvelEfcecy($_POST['dttnvel']);
			$atalzargarccon = $user->Atalzar_EtpaCptdo();
			if($atalzargarccon)
			{
				$bcarlneatepo = $user->Bcar_lneatepo();
				setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
				foreach ($bcarlneatepo as $key) {
					$fchahra = $key['fchareg'];
					$nombre_mes = strftime("%B", strtotime($fchahra));
					$nombre_mes_mayuscula = ucfirst($nombre_mes);
					$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
					$horaFormateada = date("g:i a", strtotime($fchahra));

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
													<img src="imgnes/cdgopsnal/'.$key['ucoduser'].'.jpg">
												</div>
											</div>
											<div class="dns-bdy">
												<span>'.$key['dccon'].'</span>
											</div>
										</div>
									</div>
									';
					$etlodnstlttlo = null;				
				}
				//Buscar Linea de tiempo

				echo json_encode(array('sttus' => true, 'dtudteetpagarccon' => $_POST['dtudteetpagarccon']. ' 1', 'dtlneatepo' => $ltalneatepo));
			}
			else
			{
			echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1 '));
			}
		}
		else
		{
			echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
		}
	}
	else
	{
		if($dtcdgoltrasnmros)
		{ 
			$user->setCodUser($userInfo['ucoduser']);
			$user->setdtEtdo($_POST['dtudteetpagarccon']);
			$atalzargarccon = $user->Atalzar_EtpaGaRccon();
			if($atalzargarccon)
			{
				$bcarlneatepo = $user->Bcar_lneatepo();
				setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
				foreach ($bcarlneatepo as $key) {
					$fchahra = $key['fchareg'];
					$nombre_mes = strftime("%B", strtotime($fchahra));
					$nombre_mes_mayuscula = ucfirst($nombre_mes);
					$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
					$horaFormateada = date("g:i a", strtotime($fchahra));

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
													<img src="imgnes/cdgopsnal/'.$key['ucoduser'].'.jpg">
												</div>
											</div>
											<div class="dns-bdy">
												<span>'.$key['dccon'].'</span>
											</div>
										</div>
									</div>
									';
					$etlodnstlttlo = null;				
				}
				//Buscar Linea de tiempo

				echo json_encode(array('sttus' => true, 'dtudteetpagarccon' => $_POST['dtudteetpagarccon']. ' 2', 'dtlneatepo' => $ltalneatepo));
			}
			else
			{
			    echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1'));
			}
		}
		else
		{
			echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
		}
	}

}
elseif ( $userInfo['ucoduser'] == $dtprivilegios['cadorid'] )
{
	if( $_POST['dtudteetpagarccon'] == "Completado" )
	{
		if($dtcdgoltrasnmros)
		{ 
			$user->setCodUser($userInfo['ucoduser']);
			$user->setdtRpsbleId($dtprivilegios['rpsbleid']);
			$user->setdtEtdo($_POST['dtudteetpagarccon']);
			$user->setdtLvelEfcecy($_POST['dttnvel']);
			$atalzargarccon = $user->Atalzar_EtpaCptdo();
			if($atalzargarccon)
			{
				$bcarlneatepo = $user->Bcar_lneatepo();
				setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
				foreach ($bcarlneatepo as $key) {
					$fchahra = $key['fchareg'];
					$nombre_mes = strftime("%B", strtotime($fchahra));
					$nombre_mes_mayuscula = ucfirst($nombre_mes);
					$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
					$horaFormateada = date("g:i a", strtotime($fchahra));

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
													<img src="imgnes/cdgopsnal/'.$key['ucoduser'].'.jpg">
												</div>
											</div>
											<div class="dns-bdy">
												<span>'.$key['dccon'].'</span>
											</div>
										</div>
									</div>
									';
					$etlodnstlttlo = null;				
				}
				//Buscar Linea de tiempo

				echo json_encode(array('sttus' => true, 'dtudteetpagarccon' => $_POST['dtudteetpagarccon']. ' 1', 'dtlneatepo' => $ltalneatepo));
			}
			else
			{
			    echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1 '));
			}
		}
		else
		{
			echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
		}
	}
	else
	{
		if($dtcdgoltrasnmros)
		{ 
			$user->setCodUser($userInfo['ucoduser']);
			$user->setdtEtdo($_POST['dtudteetpagarccon']);
			$atalzargarccon = $user->Atalzar_EtpaGaRccon();
			if($atalzargarccon)
			{
				$bcarlneatepo = $user->Bcar_lneatepo();
				setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
				foreach ($bcarlneatepo as $key) {
					$fchahra = $key['fchareg'];
					$nombre_mes = strftime("%B", strtotime($fchahra));
					$nombre_mes_mayuscula = ucfirst($nombre_mes);
					$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
					$horaFormateada = date("g:i a", strtotime($fchahra));

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
													<img src="imgnes/cdgopsnal/'.$key['ucoduser'].'.jpg">
												</div>
											</div>
											<div class="dns-bdy">
												<span>'.$key['dccon'].'</span>
											</div>
										</div>
									</div>
									';
					$etlodnstlttlo = null;				
				}
				//Buscar Linea de tiempo

				echo json_encode(array('sttus' => true, 'dtudteetpagarccon' => $_POST['dtudteetpagarccon']. ' 2', 'dtlneatepo' => $ltalneatepo));
			}
			else
			{
			    echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1 '));
			}
		}
		else
		{
			echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
		}
	}
}
elseif ( $userInfo['ucoduser'] == $dtprivilegios['rpsbleid'] )
{
	if( $_POST['dtudteetpagarccon'] == "Completado" )
	{
		echo json_encode(array('sttus' => false, 'message' => '<script>alert("Solo el creador de la tarea puede pasar a la etapa Completado.");</script>'));
	}
	elseif( $_POST['dtudteetpagarccon'] == "Pendientes de Revisar" )
	{
		if($dtcdgoltrasnmros)
		{ 
			$user->setCodUser($userInfo['ucoduser']);
			$user->setdtEtdo($_POST['dtudteetpagarccon']);
			$atalzargarccon = $user->Atalzar_EtpaGaRccon();
			if($atalzargarccon)
			{
				$bcarlneatepo = $user->Bcar_lneatepo();
				setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
				foreach ($bcarlneatepo as $key) {
					$fchahra = $key['fchareg'];
					$nombre_mes = strftime("%B", strtotime($fchahra));
					$nombre_mes_mayuscula = ucfirst($nombre_mes);
					$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
					$horaFormateada = date("g:i a", strtotime($fchahra));

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
													<img src="imgnes/cdgopsnal/'.$key['ucoduser'].'.jpg">
												</div>
											</div>
											<div class="dns-bdy">
												<span>'.$key['dccon'].'</span>
											</div>
										</div>
									</div>
									';
					$etlodnstlttlo = null;				
				}
				//Buscar Linea de tiempo

				echo json_encode(array('sttus' => true, 'dtudteetpagarccon' => $_POST['dtudteetpagarccon'], 'dtlneatepo' => $ltalneatepo));
			}
			else
			{
			    echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1 '));
			}
		}
		else
		{
			echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
		}
	}
}


?>