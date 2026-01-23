<?php

include "../../../modules/warranty/classes/searchdescripcion.php";
 
$user = new user();
$searchdescripcion = new searchdescripcion();
if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

$searchResultHTML = "";
$searchdescripcion->setSearchString($_POST["query"]);
$listsarchstring = $searchdescripcion->GetList();
if ($listsarchstring && $listsarchstring->num_rows > 0) {
	while ($row = $listsarchstring->fetch_array(MYSQLI_ASSOC)) {
            $searchResultHTML .= '
                                <div class="dns_data">
                                    <span class="dns_datacodigo d-none">'.$row['codigo'].'</span>
                                    <span class="dns_datadescripcion">'.trim($row['descripcion']).'</span>
                                    <span class="dns_datacategoria d-none">'.$row['categoria'].'</span>
                                    <span class="dns_datasubcategoria d-none">'.$row['subcategoria'].'</span>
                                    <span class="dns_datamarca d-none">'.$row['marca'].'</span>
                                </div>';
	}
	echo $searchResultHTML;
}
else{
	echo "Sin resultados";
}

?>