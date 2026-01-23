<?php
include "../../csses/warranty/updatestage.php";

$user = new User();
$updatestage = new updatestage();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->SetUCodUser($coduser);
$userInfo = $user->getUserInfo();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $updatestage->SetWGuideNumber($_POST["cardid"]);
  $updatestage->SetUCodUser($userInfo['ucoduser']);
  $updatestage->SetWStage($_POST["stage"]);
  $check = $updatestage->UpdateStage();
  if($check){
        echo json_encode(array('sttus' => true, 'msge' => 'Etapa cambiada'));
  }

}

?>
