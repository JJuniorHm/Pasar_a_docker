<?php

include "include/class_efcecytask.php";

$user = new user();
$efcecytask = new efcecytask();

    if(!empty($_SESSION['ucoduser'])){
    $coduser = $_SESSION['ucoduser'];
    }
    if ($user->getSession()===FALSE) {
    header("location:lgn.php");
    }
    if (isset($_GET['q'])) {
    $user->logout();
    header("location:lgn.php");
    }
$searchResultHTML = "";

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();
$efcecytask->setCodUser($userInfo["ucoduser"]);
$efcecytask->setUserAra($userInfo["area"]);

$areas = ["Distribución", "Contabilidad", "Online","Informática", "Recursos Humanos", "Marketing"];

$listaras = null;
foreach ($areas as $area) {
    $selected = ($userInfo["area"] == $area) ? "selected" : "";
    $listaras .= '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
}

$infoefcecy = $efcecytask->GetInfoEfcecy();
$infoaraefcecy = $efcecytask->GetInfoAreaEfcecy();

$listaraefcecy = null;
foreach ($infoaraefcecy as $key) {
                                                                
    $listaraefcecy.= '
                    <tr>
                        <th scope="row">'.$key['unombre1'].' '.$key['upaterno'].'</th>
                        <td>'.$key['efcecy'].'%</td>
                    </tr>';
}
//$ftrospdtos->EvarCdnaBqda($_POST["query"]);
//$listcdnabqda = $ftrospdtos->GetListCdeUser();
            $searchResultHTML = '
                                <div class="container-fluid">
                                    <div class="row justify-content-between">
                                        <div class="col-lg-6 py-1">
                                            <div class="dns_card">
                                                <div class="dns_cardhader">
                                                Eficiencia Personal
                                                </div>
                                                <div class="dns_cardbdy">
                                                    <div class="dns_ctnerefcecy">
                                                        <div class="tjta" id="arco" data-value="'.(($infoefcecy['efcecy'] ?? 100) + 1 ).'">
                                                            <div class="box">
                                                            <div class="percent">
                                                                <svg>
                                                                <circle cx="70" cy="70" r="70"></circle>
                                                                <circle cx="70" cy="70" r="70"></circle>
                                                                </svg>
                                                                <div class="number">
                                                                <h2>75<span>%</span></h2>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 py-1">
                                            <div class="dns_card">
                                                <div class="dns_cardhader">
                                                    <select id="araefcecy">
                                                        '.$listaras.'
                                                    </select>
                                                </div>
                                                <div class="dns_cardbdy">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Usuario</th>
                                                                <th scope="col">Eficiencia</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listaraefcecy">
                                                        '.$listaraefcecy.'
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
    echo json_encode(array('html' => $searchResultHTML));

?>
