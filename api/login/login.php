<?php
header('Content-Type: application/json; charset=utf-8');

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/Sconzton.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/csses/class_lgin/lgin.php";

// Leer datos (JSON o form)
$input = json_decode(file_get_contents("php://input"), true);
$coduser = $_POST['coduser'] ?? ($input['coduser'] ?? '');
$pword   = $_POST['pword']   ?? ($input['pword']   ?? '');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'sttus' => false,
        'msge'  => 'Método no permitido'
    ]);
    exit;
}

if ($coduser === '' || $pword === '') {
    echo json_encode([
        'sttus' => false,
        'msge'  => 'Faltan datos'
    ]);
    exit;
}

$lgin = new Lgin();
$lgin->setCodUser($coduser);
$lgin->setPword($pword);

$user = $lgin->doLogin();

if (is_array($user)) {
    $_SESSION['ucoduser'] = $user['ucoduser'];
    $_SESSION['lgingtoritgral'] = true;

    echo json_encode([
        'sttus' => true,
        'user'  => [
            'id' => $user['ucoduser']
        ]
    ]);
    exit;
}

echo json_encode([
    'sttus' => false,
    'msge'  => 'El usuario o contraseña es incorrecto'
]);
exit;
