<?php

include "../../../modules/warranty/classes/searchclient.php";
 
$user = new user();
$searchclient = new searchclient();
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

$searchResultHTML = "";
$searchclient->setSearchString($_POST["query"]);
$listsarchstring = $searchclient->GetList();
if ($listsarchstring && $listsarchstring->num_rows > 0) {
	while ($row = $listsarchstring->fetch_array(MYSQLI_ASSOC)) {
            $razon = $row['crazon'];
            $code = $row['ccodcli'];
            $searchResultHTML .= '
                                <div class="dns_data">
                                    <span class="dns_datarazon">'.$razon.'</span>
                                    <span class="dns_datacode" >'.$code.'</span>
                                </div>';
	}
    echo json_encode(array("status" => true, 'resulthtml' => $searchResultHTML, 'validate' => '<div class="dns_gb_success dns_clr_success dns_txt_success fw-bold text-center p-2 w-100"> Datos localizados puede seguir con el registro</div>' ));
}
else{
	echo json_encode(array("status" => false, 'resulthtml' => $searchResultHTML ));
}

?>
