<?php
include "../../csses/task/addcmtstask.php";

if(isset($_POST["dtcmtros"]) && !empty($_POST["dtcmtros"])) {
} else {
    echo json_encode(array('sttus' => false, 'message' => 'Por favor ingrese un Comentario.'));
    exit(); // Detener la ejecución del script
}

$user = new User();
$addcmts = new addcmts();


$status = '';
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

//Buscar Linea de tiempo
$ltalneatepo = null;
$ltacmtros = null;
$atrorfcha = null;
$ipmirfcha = null;
$etlodnstlttlo = null;

if(isset($_POST["dtlistaurl"]) && !empty($_POST["dtlistaurl"])) {

    $listurl = $_POST['dtlistaurl'];

    $extensionClasses = array(
	    "doc" => "<i class='bx bxs-file-doc'></i>",
	    "docx" => "<i class='bx bxs-file-doc'></i>",
	    "xls" => "<i class='bx bxs-file'></i>",
	    "xlsx" => "<i class='bx bxs-file'></i>",
	    "pdf" => "<i class='bx bxs-file-pdf'></i>"
        // Puedes agregar más extensiones aquí si es necesario
    );
    // Creamos un array para almacenar los enlaces generados
    $links = [];

    // Iteramos sobre cada URL en el array
    foreach($listurl as $url) {

    	$extension = pathinfo($url, PATHINFO_EXTENSION);
    	$class = isset($extensionClasses[$extension]) ? $extensionClasses[$extension] : '';

        // Creamos un enlace HTML alrededor de cada URL y lo agregamos al array de enlaces
        $links[] = '<a  href="' . htmlspecialchars($url) . '"class="dns_btndownloadfile"><span class="dns_ttledownloadfile">' . $class . '' . basename($url) . '</span></a><br>';
    }

	$output = implode(' ', $links);
} else {
	$output = '';
}

$addcmts->setNumberId($_POST['dttnmroid']);
$check = $addcmts->CheckRgter();
if($check)
{ 
	$addcmts->setCodUser($userInfo['ucoduser']);
	$addcmts->setCmts($_POST['dtcmtros'].''.$output);
	$checkcmts = $addcmts->AddCmts();
	if($checkcmts)
	{
		$getmelne = $addcmts->Get_TmeLne();
		setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
		foreach ($getmelne as $key) {
			$fchahra = $key['fchareg'];
			$nombre_mes = strftime("%B", strtotime($fchahra));
			$nombre_mes_mayuscula = ucfirst($nombre_mes);
			$fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
			$horaFormateada = date("g:ia", strtotime($fchahra));

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
		}
		if (empty($ltacmtros)) {
		    $ltacmtros = '<div class="ctndornp my-2 p-2">Aún no hay Comentarios.</div>';
		}

		echo json_encode(array('sttus' => true, 'message' => 'Se Actualizo correctamente', 'dtlneatepo' => $ltalneatepo, 'dttracmtros' => $ltacmtros));
	}
	else
	{
	  echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente.'));
	}
}
else
{
	echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al actualizar, por favor intentelo nuevamente.'));
}



?>