<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

include "../../../modules/warranty/classes/reloadkanban.php";
$user = new user();
$reloadkanban = new reloadkanban();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();
 
$reloadkanban->EvarCdnaBqda($_POST["sarchtask"]);
$reloadkanban->setCodUser($coduser);
$listcards = $reloadkanban->GetListKanban();

$ctinerclumns = array(
  "GESTIÓN DE INTERNAMIENTO",
  "GESTIÓN DE ENVÍO: PROVEEDOR",
  "GESTIÓN DE RETORNO: PROVEEDOR",
  "GESTIÓN DE SALIDA"
);

$ctentcolumns = array();

foreach ($ctinerclumns as $estado) {
  $ctentcolumns[$estado] = array();
}

if ($listcards->num_rows > 0) {
  while ($row = $listcards->fetch_assoc()) {
    $ctentcolumns[$row["wstage"]][] = $row;
  }
}
$listkban = null;
$nberclum = 1;
$count = 0;
$totalsoles = 0;
$listkban = '<div id="dns_arrowleftkban" class="dns_arrowleftkban"><i class="bx bxs-chevrons-left"></i></div>
            <div id="dns_boardkban" class="dns_boardkban">';
foreach ($ctentcolumns as $estado => $tasks) {
    foreach ($tasks as $task) { 
      if($estado == "GESTIÓN DE INTERNAMIENTO"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      }
      if($estado == "GESTIÓN DE ENVÍO: PROVEEDOR"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      }
      if($estado == "GESTIÓN DE RETORNO: PROVEEDOR"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      } 
      if($estado == "GESTIÓN DE SALIDA"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      }
    }
    
    
  $cloretdo = "";
  if($estado == "GESTIÓN DE INTERNAMIENTO"){
    $cloretdo = "#ff3000";
  }
  if($estado == "GESTIÓN DE ENVÍO: PROVEEDOR"){
    $cloretdo = "#0C2A98";
  }
  if($estado == "GESTIÓN DE RETORNO: PROVEEDOR"){
    $cloretdo = "#0C2A98";
  } 
  if($estado == "GESTIÓN DE SALIDA"){
    $cloretdo = "#5AAC00";
  }
  $listkban .= '
	            <div class="dns_clumnkban">
	            	<h6 class="text-truncate" style="background-color: '.$cloretdo.';">' . $estado . '</h6>
	            	<div class="d-flex justify-content-around"><span>Cantidad: '.$count.'</span><span >Total S/'.number_format($totalsoles, 2) .'</span></div>
	            	<div class="dns_ctinerclumn" id="' . $estado . '">
	            	';
    
    // Imprimir la lista de tareas
    foreach ($tasks as $task) {
      $fecha_actual = new DateTime();
      $colorstate = 'style="border:1px dashed #7db047;"';
      $fecha_inicio_obj = new DateTime($task["wentrydate"]);
      $fecha_actual = new DateTime();
      $diferencia = $fecha_inicio_obj->diff($fecha_actual)->days;
      if ($diferencia > 9 && $diferencia <= 20) {
        $colorstate = 'style="border:1px dashed #f0ce00;"';
      }
      if ($diferencia > 20) {
        $colorstate = 'style="border:1px dashed #ff1753;"';
      }
      $wstate = $task["wstate"];
      if ($task["wstate"] == "") {
        $wstate = 'AÚN SIN ESTADO';
      }
      $listkban .= '
            <div class="dns_cardkban" id="'.$task['wguidenumber'].'" '.$colorstate.'>
              <div id="idtask" style="display:none;">'.$task["wguidenumber"].'</div>
              <div class="dns_infotask">'.$task["wendpoint"].'-'.str_pad($task["wguidenumber"], 8, '0', STR_PAD_LEFT).'</div>
              <span>Estado</span>
              <div class="dns_infotask text-primary" >'.$wstate.'</div>
              <span>Responsable</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["urazon"], 0,50)).'</div>

              <span>Cliente</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["crazon"], 0,50)).'</div>

              <span>Producto</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["descripcion"], 0,50)).'</div>

              <span>Fecha de Internamiento</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["wentrydate"], 0,50)).'</div>
            </div>';
    }
    
    $listkban .= '
            </div>
          </div>';
    $nberclum++;
}
$listkban .= '<div class="dns_arrowrightkban" id="dns_arrowrightkban"><i class="bx bxs-chevrons-right"></i></div>
              </div>';

$response = array('sttus' => true, 'html' => $listkban);

// Codificamos el array completo
echo json_encode($response);
 
}
?>
