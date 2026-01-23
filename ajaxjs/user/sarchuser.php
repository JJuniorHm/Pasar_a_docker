<?php

include "../../csses/user/sarchuser.php";

$user = new user();
$searchuser = new searchuser();
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

$searchResultHTML = "";
$searchuser->setSarchString($_POST["query"]);
$listsarchstring = $searchuser->GetListCdeUser();
if ($listsarchstring && $listsarchstring->num_rows > 0) {
	while ($row = $listsarchstring->fetch_array(MYSQLI_ASSOC)) {
            $dteuser = $row['urazon'];
            $dtecdgo = $row['ucoduser'];
            $searchResultHTML .= '
                                <div class="dns_dtdteuser">
                                    <span class="dteuser">'.$dteuser.'</span>
                                    <span class="dtecdgo" >'.$dtecdgo.'</span>
                                </div>'; 
	}
	echo $searchResultHTML;
}
else{
	echo "Sin resultados";
}

?>
