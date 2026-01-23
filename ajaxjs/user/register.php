<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require $_SERVER['DOCUMENT_ROOT'] . "/Comsitec/includes/Sconzton.php";

$conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conexion->connect_error) {
    echo json_encode(["status"=>false,"message"=>"Error de conexión"]);
    exit;
}

function clean($v){
    return trim($v);
}

/* ===========
 DATOS
=========== */
$ucoduser   = clean($_POST['ucoduser'] ?? '');
$udni       = clean($_POST['udni'] ?? '');
$upaterno   = clean($_POST['upaterno'] ?? '');
$umaterno   = clean($_POST['umaterno'] ?? '');
$unombre1   = clean($_POST['unombre1'] ?? '');
$unombre2   = clean($_POST['unombre2'] ?? '');
$urazon     = clean($_POST['unombrecompleto'] ?? '');
$passRaw    = $_POST['upassword'] ?? '';
$telefonos  = $_POST['utelefono'] ?? [];

$utelefono1 = clean($telefonos[0] ?? '');
$utelefono2 = clean($telefonos[1] ?? '');

/* ===========
 VALIDACIONES
=========== */

if (!preg_match('/^\d{4}$/', $ucoduser)) {
    echo json_encode(["status"=>false,"message"=>"El código debe tener 4 dígitos"]);
    exit;
}

if (!preg_match('/^\d{8}$/', $udni)) {
    echo json_encode(["status"=>false,"message"=>"DNI no válido"]);
    exit;
}

if ($passRaw === '' || $utelefono1 === '') {
    echo json_encode(["status"=>false,"message"=>"Faltan datos obligatorios"]);
    exit;
}

/* ===========
 VALIDAR DUPLICADOS — SEGURO
=========== */

// código usuario
$stmt = $conexion->prepare("SELECT 1 FROM tb_users WHERE ucoduser = ?");
$stmt->bind_param("s", $ucoduser);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status"=>false,"message"=>"El código ya existe"]);
    exit;
}
$stmt->close();

// DNI
$stmt = $conexion->prepare("SELECT 1 FROM tb_users WHERE udni = ?");
$stmt->bind_param("s", $udni);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status"=>false,"message"=>"El DNI ya está registrado"]);
    exit;
}
$stmt->close();

/* ===========
 INSERT — SEGURO
=========== */

$upassword = password_hash($passRaw, PASSWORD_DEFAULT);

$stmt = $conexion->prepare("
    INSERT INTO tb_users (
        ucoduser, udni, urazon, udireccion,
        utelefono1, utelefono2,
        upaterno, umaterno, unombre1, unombre2,
        ucorreo, upassword,
        u_datelogin, u_datecreate,
        codverreg, sede, area, cargo
    )
    VALUES (?, ?, ?, '', ?, ?, ?, ?, ?, ?, '', ?, NOW(), NOW(), '000000', 'PRINCIPAL', 'SIN ASIGNAR', 'USUARIO')
");

$stmt->bind_param(
    "ssssssssss",
    $ucoduser,
    $udni,
    $urazon,
    $utelefono1,
    $utelefono2,
    $upaterno,
    $umaterno,
    $unombre1,
    $unombre2,
    $upassword
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => true,
        "message" => "Usuario registrado correctamente",
        "ucoduser" => $ucoduser
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "MYSQL ERROR: " . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();
exit;
?>
