<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Comsitec/includes/Sconzton.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/Comsitec/csses/class_lgin/lgin.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'sttus' => false,
        'msge'  => 'Método no permitido'
    ]);
    exit;
}

$coduser = $_POST['coduser'] ?? '';
$pword   = $_POST['pword'] ?? '';

$lgin = new Lgin();
$lgin->setCodUser($coduser);
$lgin->setPword($pword);

$user = $lgin->doLogin();

if (is_array($user)) {

    $_SESSION['ucoduser'] = $user['ucoduser'];
    $_SESSION['lgingtoritgral'] = true;

    echo json_encode([
        'sttus' => true
    ]);
    exit;
}

echo json_encode([
    'sttus' => false,
    'msge'  => 'El usuario o contraseña es incorrecto'
]);
exit;
