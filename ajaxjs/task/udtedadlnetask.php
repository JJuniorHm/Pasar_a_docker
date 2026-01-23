<?php
include "../../csses/task/udtedadlnetask.php";

header('Content-Type: application/json');


$dttnmroid = $_POST['dttnmroid']  ?? null;
$dttfchalmte = $_POST['dttfchalmte']?? null;
$dttnvel = $_POST['dttnvel'] ?? null;

if ($dttnmroid){
  echo json_encode([
    "sttus" => false,
    "msge" => "Falta el ID de la tarea"
  ]);
  exit;
}

if($dttnvel){
  echo json_encode([
    "sttus" => false,
    "msge" => "falta el estado de la tarea"
  ]);
  exit;
}

if($dttfchalmte){
  echo json_decode([
    "sttus"=> false,
    "msge" => "falta la fecha de la tarea"
  ]);
  exit;
} 


$user = new user();
$udtedadlnetask = new udtedadlnetask();

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

$udtedadlnetask->setNumberId('dttnmroid');
$check_rgter = $udtedadlnetask->CheckRgter();

$dtprivilegios = $udtedadlnetask->GetPvlgos();

if( $userInfo['ucoduser'] == $dtprivilegios['cadorid'] && $userInfo['ucoduser'] == $dtprivilegios['rpsbleid'] )
{
    if($check_rgter)
    { 
      $udtedadlnetask->setCodUser($userInfo['ucoduser']);
      $udtedadlnetask->setdtRpsbleId($dtprivilegios['rpsbleid']);
      
      $udtedadlnetask->setdtLvelEfcecy($dttnvel);
      $udtedadlnetask->setdtFchaLmte($dttfchalmte);
      $check = $udtedadlnetask->UdteDadLne();
      if($check)
      {
        $bcarlneatepo = $udtedadlnetask->Get_TmeLne();
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
                          <img src="imges/cdgopsnal/'.$key['ucoduser'].'.jpg">
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

        echo json_encode(array('sttus' => true, 'msge' => 'Se amplio la Fecha Límite', 'dtlneatepo' => $ltalneatepo));
      }
      else
      {
        echo json_encode(array('sttus' => false, 'msge' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1 '));
      }
    }
    else
    {
      echo json_encode(array('sttus' => false, 'msge' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
    }
}
elseif ( $userInfo['ucoduser'] == $dtprivilegios['cadorid'] )
{
    if($check_rgter)
    { 
      $udtedadlnetask->setCodUser($userInfo['ucoduser']);
      $udtedadlnetask->setdtRpsbleId($dtprivilegios['rpsbleid']);
      $udtedadlnetask->setdtLvelEfcecy($_POST['dttnvel']);
      $udtedadlnetask->setdtFchaLmte($_POST['dttfchalmte']);
      $check = $udtedadlnetask->UdteDadLne();
      if($check)
      {
        $bcarlneatepo = $udtedadlnetask->Get_TmeLne();
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
                          <img src="imges/cdgopsnal/'.$key['ucoduser'].'.jpg">
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

        echo json_encode(array('sttus' => true, 'msge' => 'Se amplio la Fecha Límite', 'dtlneatepo' => $ltalneatepo));
      }
      else
      {
        echo json_encode(array('sttus' => false, 'msge' => 'Hubo un error al actualizar el documento, por favor intentelo nuevamente. 1 '));
      }
    }
    else
    {
      echo json_encode(array('sttus' => false, 'msge' => 'Hubo un error al actualizar, por favor intentelo nuevamente. 2'));
    }
}
elseif ( $userInfo['ucoduser'] == $dtprivilegios['rpsbleid'] )
{
  echo json_encode(array('sttus' => false, 'msge' => 'Solo el Creador puede cambiar la Fecha Limite.'));
}


?>