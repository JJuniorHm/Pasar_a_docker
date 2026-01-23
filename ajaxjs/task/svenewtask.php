<?php
include "../../csses/task/svenewtask.php";

$user = new user();
$newtask = new newtask();

$status = '';
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

$autonametask = "";

if( str_replace(" ", "", $_POST['dtnbretra']) == "" )
{
	$autonametask = substr($_POST['dtdccon'], 0, 50);
}
else
{
	$autonametask = $_POST['dtnbretra'];
}

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

	$newtask->setdtCadorId($userInfo['ucoduser']);
	$newtask->setdtRpsbleId($_POST['dtcdeuser']);
	$newtask->setdtNbreTra($autonametask);
	$newtask->setdtDccon($_POST['dtdccon'].''.$output);
	$newtask->setdtFchaLmte($_POST['dtfchalmte']);
	$newtask->setdtLvelEfcecy($_POST['dtlvelefcecy']);
	$gadargarccon = $newtask->savenewtask();

	if($gadargarccon)
	{
	  echo json_encode(array('sttus' => true, 'message' => 'Tarea creada.'));
	}
	else
	{
	  echo json_encode(array('sttus' => false, 'message' => 'Hubo un error al registrar el documento, por favor intentelo nuevamente.'));
	}

?>