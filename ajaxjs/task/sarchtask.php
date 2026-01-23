<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

include "../../csses/task/sarchkbantask.php";
$user = new user();
$sarchkbantask = new sarchkbantask();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();
 
$sarchkbantask->EvarCdnaBqda($_POST["sarchtask"]);
$sarchkbantask->setCodUser($coduser);
$listcards = $sarchkbantask->GetListGrtas();

$ctinerclumns = array(
  "En Progreso",
  "Pendientes de Revisar",
  "Completado",
);

$ctentcolumns = array();

foreach ($ctinerclumns as $estado) {
  $ctentcolumns[$estado] = array();
}

if ($listcards->num_rows > 0) {
  while ($row = $listcards->fetch_assoc()) {
    $ctentcolumns[$row["etdo"]][] = $row;
  }
}
$listkban = null;
$listkban2 = '<div>Ok</div>';
$nberclum = 1; 
$listkban = '<div id="dns_arrowleftkban" class="dns_arrowleftkban"><i class="bx bxs-chevrons-left"></i></div>
            <div id="dns_boardkban" class="dns_boardkban">';
foreach ($ctentcolumns as $estado => $tasks) {
  $cloretdo = "";
  if($estado == "En Progreso"){
    $cloretdo = "#ff3000";
  }
  if($estado == "Pendientes de Revisar"){
    $cloretdo = "#0C2A98";
  }
  if($estado == "Completado"){
    $cloretdo = "#5AAC00";
  }
  $listkban .= '
              <div class="dns_clumnkban">
                <h6 class="text-truncate" style="background-color: '.$cloretdo.';">' . $estado . '</h6>
                <div class="dns_ctinerclumn" id="' . $estado . '">
                <div class="dns_nberclumn">'.$nberclum.'</div>';
    
    // Imprimir la lista de tareas
    foreach ($tasks as $task) {
      $cloretdofchalmte ="";
      if($task["etdofchalmte"] == "A Tiempo"){
        $cloretdofchalmte = "#5AAC00";
      }
      if($task["etdofchalmte"] == "Atrasado"){
        $cloretdofchalmte = "#DE013B";
      }
        $listkban .= '
              <div class="dns_cardkban" style="border-bottom: 1px groove '.$cloretdofchalmte.';" id="'.$task['nmroid'].'">
                <label>Descripción</label>
                <div class="dns_infotask">'.strip_tags(mb_substr($task["dccon"], 0,50)).'</div>
                <div id="idtask" style="display:none;">'.$task["nmroid"].'</div>
                <div class="dns_infotask" style="display:none;">Tarea-'.str_pad($task["nmroid"], 8, '0', STR_PAD_LEFT).'</div>
                <label>Creador</label>
                <div class="text-truncate dns_infotask">'.$task["cunombre1"].' '.$task["cupaterno"].'</div>
                <label>Responsable</label>
                <div class="text-truncate dns_infotask">'.$task["runombre1"].' '.$task["rupaterno"].'</div>
                <label>Fecha de internamiento</label>
                <div class="dns_infotask">'.$task["fchareg"].'</div>
                <label>Fecha Límite</label>
                <div class="dns_infotask">'.$task["fchalmte"].'</div>
                <label>Nivel de Entrega</label>
                <div id="lveldlvry" class="dns_infotask">'. $task["nvel"].'</div>
                <label>Estado Fecha Limite</label>
                <div id="deadline" class="dns_infotask" style="color:'.$cloretdofchalmte.';">'. $task["etdofchalmte"].'</div>
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
