<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

include "../../../modules/warranty/classes/update_service_w.php";
$user = new user();
$update_service_w = new update_service_w();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();
 
$atrorfcha = null;
$ltalneatepo = null;

$update_service_w->SetUCodUser($userInfo['ucoduser']);
$update_service_w->SetWGuideNumber($_POST['wguidenumber']);
$update_service_w->setWAccessories($_POST['waccessories']);
$update_service_w->setWPRPC($_POST['wprpc']);
$update_service_w->setWEquipmentStatus($_POST['wequipmentstatus']);
$update_service_w->setWDiagnostic($_POST['wdiagnostic']);
$update_service_w->setWProblemsDetected($_POST['wproblemsdetected']);
$update_service_w->setWConcludingRemarks($_POST['wconcludingremarks']);

$check_update_service_w = $update_service_w->update_service_w();
if($check_update_service_w){
	// Codificamos el array completo
	echo json_encode(array('sttus' => true,
	                   'message' => 'Guía '.$_POST['wguidenumber'].' actualizada correctamente.' ));
} else {
	// Codificamos el array completo
	echo json_encode(array('sttus' => false,
	                   'message' => 'Problemas al actualizar la guía '.$_POST['wguidenumber']));
}
}
?>
