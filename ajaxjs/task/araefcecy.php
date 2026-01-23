<?php

include "../../csses/task/efcecytask.php";

$user = new user();
$efcecytask = new efcecytask();

if (!empty($_SESSION['ucoduser'])) {
    $coduser = $_SESSION['ucoduser'];
}

if ($user->getSession() === FALSE) {
    header("location:lgn.php");
    exit;
}

if (isset($_GET['q'])) {
    $user->logout();
    header("location:lgn.php");
    exit;
}

/* ==========================
 VALIDAR PARÁMETRO
========================== */

$area = $_POST["araefcecy"] ?? "";

// quitar espacios y tags
$area = trim(strip_tags($area));

// lista de áreas válidas (ajusta según tu sistema)
$areasValidas = [
    "Distribución",
    "Contabilidad",
    "Online",
    "Informática",
    "Recursos Humanos",
    "Marketing",
    "Corporativo"
];

if (!in_array($area, $areasValidas)) {
    echo json_encode([
        "html" => "<tr><td colspan='2'>Área no válida</td></tr>"
    ]);
    exit;
}

/* ==========================
CONTINUAR NORMAL
========================== */

$efcecytask->setUserAra($area);

$infoareaefcecy = $efcecytask->GetInfoAreaEfcecy();

$searchResultHTML = "";

foreach ($infoareaefcecy as $key) {
    $searchResultHTML .= '
        <tr>
            <th scope="row">'.$key['unombre1'].' '.$key['upaterno'].'</th>
            <td>'.$key['efcecy'].'%</td>
        </tr>';
}

echo json_encode([
    'html' => $searchResultHTML
]);

?>
