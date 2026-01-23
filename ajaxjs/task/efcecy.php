<?php
include "../../csses/task/efcecytask.php";
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

$areas = ["Distribución", "Contabilidad", "Online","Informática", "Recursos Humanos", "Marketing","Corporativo"];

$listaras = "";
foreach ($areas as $area) {
    $selected = ($userInfo["area"] == $area) ? "selected" : "";
    $listaras .= '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
}

$infoefcecy = $efcecytask->GetInfoEfcecy();
$infoaraefcecy = $efcecytask->GetInfoAreaEfcecy();
$get_ListResponsible = $efcecytask->get_ListResponsible();

$listyear = "";
$get_ListYear = $efcecytask->get_ListYear();

foreach ($get_ListYear as $key) {
    $listyear .= '<option value="'.$key['dtergter'].'">'.$key['dtergter'].'</option>';
}

$currentYear = date("Y");

if (strpos($listyear, $currentYear) === false) {
    $listyear .= '<option value="'.$currentYear.'">'.$currentYear.'</option>';
}

$listmonth = "";

$get_ListMonth = $efcecytask->get_ListMonth();
$currentMonth = date("n");

if ($get_ListMonth && $get_ListMonth->num_rows > 0) {

    $monthsFound = [];
    while ($row = $get_ListMonth->fetch_assoc()) {
        $monthsFound[] = (int)$row['dtergter'];
    }

    $minMonth = 1;
    $maxMonth = max($monthsFound);

    for ($m = $minMonth; $m <= $maxMonth; $m++) {
        $listmonth .= '<option value="'.$m.'">'.$m.'</option>';
    }

} else {

    for ($m = 1; $m <= $currentMonth; $m++) {
        $listmonth .= '<option value="'.$m.'">'.$m.'</option>';
    }
}

$listresponsible = "";
foreach ($get_ListResponsible as $key) {
    $listresponsible .= '<option value="'.$key['rpsbleid'].'">'.$key['urazon'].'</option>';
}

$listaraefcecy = "";
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
                                                                <svg class="dns_svg">
                                                                <circle class="dns_circle" cx="70" cy="70" r="70"></circle>
                                                                <circle class="dns_circle" cx="70" cy="70" r="70"></circle>
                                                                </svg>
                                                                <div class="number">
                                                                <h2 class="dns_h2">75<span class="dns_span">%</span></h2>
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
                                        <div class="col-12">
                                            <div class="dns_card">
                                                <div class="dns_cardhader">
                                                    Eficiencia de tareas
                                                </div>
                                                <div class="dns_cardbdy" style=" ">
                                                    <div class="dns_containerform">
                                                        <div class="dns_content_input display-flex">
                                                            <select id="listresponsible" class="dns_input">
                                                                <option value="">Seleccione un responsable</option>
                                                                '.$listresponsible.'
                                                            </select>
                                                        </div>
                                                        <div class="dns_content_input display-flex">
                                                            <select id="list_year" class="dns_input">
                                                                '.$listyear.'
                                                            </select>
                                                        </div>
                                                        <div class="dns_content_input display-flex">
                                                            <select id="list_month" class="dns_input">
                                                                '.$listmonth.'
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="splineChart">
                                                        <div id="gfcolnalgc" style=" width: 100%; height: 100%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="assets/js/5.0.2_echarts.min.js"></script>
                                <script src="assets/js/ChartLine_eficiencytask.js"></script>
                                ';
    echo json_encode(array('html' => $searchResultHTML));

?>