<?php
include "../../csses/warranty/insert_w.php";

$user = new user();
$insert_w = new insert_w();

$status = '';
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setUCodUser($coduser);
$userInfo = $user->getUserInfo();

if( strlen($_POST['ccodcli']) < 8 ){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'ccodcli' , 'message' => 'Los caracteres mínimos son 8 en "Cliente".'));
	exit();
}
if( strlen($_POST['wvaucher']) < 5){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'wvaucher' , 'message' => 'Los caracteres mínimos son 5 en "Comprobante".'));
	exit();
}
if (!is_numeric($_POST['wpriceproduct'])) {
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'wpriceproduct' , 'message' => 'Ingrese solo un valor entero o decimal en "Precio del Producto".'));
	exit();
} elseif ($_POST['wpriceproduct'] != (float)$_POST['wpriceproduct'] ) {
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'wpriceproduct' , 'message' => 'Ingrese solo un valor entero o decimal en "Precio del Producto".'));
	exit();
}
if( strlen($_POST['codigo']) != 12 ){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'codigo' , 'message' => 'Debe contener 12 caracteres en "Código".'));
	exit();
}
if( strlen($_POST['descripcion']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'descripcion' , 'message' => 'Rellene los datos correctos en "Descripción".'));
	exit();
}
if( strlen($_POST['categoria']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'categoria' , 'message' => 'Rellene los datos correctos en "Categoría".'));
	exit();
}
if( strlen($_POST['subcategoria']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'subcategoria' , 'message' => 'Rellene los datos correctos en "SubCategoría".'));
	exit();
}
if( strlen($_POST['marca']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'marca' , 'message' => 'Rellene los datos correctos en "Marca".'));
	exit();
}
if( strlen($_POST['waccessories']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'waccessories' , 'message' => 'Rellene los datos correctos en  "Accesorios".'));
	exit();
}
if( strlen($_POST['serialnumber']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'serialnumber' , 'message' => 'Rellene los datos correctos en  "Número de Serie".'));
	exit();
}
if( strlen($_POST['wprpc']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'wprpc' , 'message' => 'Rellene los datos correctos en "Problema Reportado".'));
	exit();
}
if( strlen($_POST['wequipmentstatus']) < 2){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'wequipmentstatus' , 'message' => 'Rellene los datos correctos en "Observaciones del Producto".'));
	exit();
}
if( strlen($_POST['wdiagnostic']) < 2 ){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'wdiagnostic' , 'message' => 'Rellene los datos correctos en "Diagnostico".'));
	exit();
}
if( strlen($_POST['dtfchalmte']) < 2 ){
	echo json_encode(array('status' => false, 'validation' => 'dns_border_danger', 'inputdata' => 'dtfchalmte' , 'message' => 'El campo Fecha estimada esta vacia.'));
	exit();
}

$insert_w->setUCodUser($userInfo['ucoduser']);
$insert_w->setCCodcli($_POST['ccodcli']);
$insert_w->setWVaucher($_POST['wvaucher']);
$insert_w->setWPriceProduct($_POST['wpriceproduct']);
$insert_w->setCodigo($_POST['codigo']);
$insert_w->setDescripcion($_POST['descripcion']);
$insert_w->setCategoria($_POST['categoria']);
$insert_w->setSubcategoria($_POST['subcategoria']);
$insert_w->setMarca($_POST['marca']);
$insert_w->setWAccessories($_POST['waccessories']);
$insert_w->setSerialNumber($_POST['serialnumber']);
$insert_w->setWPRPC($_POST['wprpc']);
$insert_w->setWEquipmentStatus($_POST['wequipmentstatus']);
$insert_w->setWDiagnostic($_POST['wdiagnostic']);
$insert_w->setWProblemsDetected($_POST['wproblemsdetected']);
$insert_w->setWConcludingRemarks($_POST['wconcludingremarks']);
$insert_w->setDTFchalmte($_POST['dtfchalmte']);
$check = $insert_w->insert_w();
if($check){
	echo json_encode(array('status' => true, 'validation' => '', 'inputdata' => '' , 'message' => 'Se Registro correctamente.'));
} else {
	echo json_encode(array('status' => false, 'validation' => '', 'inputdata' => '' , 'message' => 'Error al registrar.'));
}

?>