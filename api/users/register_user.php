<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/Sconzton.php";
$cn = DBConnection::getInstance()->getConnection();

function generarPassword($len = 8){
    return substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789"),0,$len);
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);
$data = array_merge($_POST, $input ?? []);

switch ($method) {

    case 'POST':

        $ucoduser   = $data['ucoduser']   ?? '';
        $udni       = $data['udni']       ?? '';
        $urazon     = $data['urazon']     ?? '';
        $udireccion = $data['udireccion'] ?? '';
        $utelefono1 = $data['utelefono1'] ?? '';
        $utelefono2 = $data['utelefono2'] ?? '';
        $upaterno   = $data['upaterno']   ?? '';
        $umaterno   = $data['umaterno']   ?? '';
        $unombre1   = $data['unombre1']   ?? '';
        $unombre2   = $data['unombre2']   ?? '';
        $ucorreo    = $data['ucorreo']    ?? '';
        $sede       = $data['sede']       ?? '';
        $area       = $data['area']       ?? '';
        $cargo      = $data['cargo']      ?? '';

        if ($ucoduser=='' || $udni=='' || $unombre1=='') {
            echo json_encode(['ok'=>false,'msg'=>'Faltan datos obligatorios']);
            exit;
        }

        // Verificar duplicados
        $check = $cn->prepare(
            "SELECT ucoduser FROM tb_users 
                WHERE ucoduser=? OR udni=? OR ucorreo=?"
        );
        $check->bind_param("sss", $ucoduser, $udni, $ucorreo);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo json_encode(['ok'=>false,'msg'=>'Usuario, DNI o correo ya existen']);
            exit;
        }

        // Generar contraseña automática
        $plainPass = generarPassword(8);
        $hash = password_hash($plainPass, PASSWORD_BCRYPT);

        $codverreg = rand(100000, 999999);
        $mustChange = 1;

        $stmt = $cn->prepare(
                "INSERT INTO tb_users
                (ucoduser,udni,urazon,udireccion,utelefono1,utelefono2,
                upaterno,umaterno,unombre1,unombre2,ucorreo,upassword,
                u_datelogin,u_datecreate,codverreg,sede,area,cargo,u_must_change_pass)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),?,?,?,?,?)"
            );

        $stmt->bind_param(
            "ssssssssssssssssi",
            $ucoduser,$udni,$urazon,$udireccion,$utelefono1,$utelefono2,
            $upaterno,$umaterno,$unombre1,$unombre2,$ucorreo,$hash,
            $codverreg,$sede,$area,$cargo,$mustChange
        );

        $stmt->execute();

        echo json_encode([
            'ok'=>true,
            'msg'=>'Usuario registrado',
            'password'=>$plainPass,
            'codverreg'=>$codverreg
        ]);
        break;

    default:
        echo json_encode([
            'ok'=>false,
            'msg'=>'Método no soportado'
        ]);
}
