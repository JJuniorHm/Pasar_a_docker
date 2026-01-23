<?php
header('Content-Type: application/json; charset=utf-8');
require_once $_SERVER['DOCUMENT_ROOT'] . "/Comsitec/includes/Sconzton.php";
$cn = DBConnection::getInstance()->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);
$data = array_merge($_POST, $input ?? []);

// Normalización como en tu web
$map = [
    'pag_taskmnger'      => 'tasks',
    'pag_warranty'       => 'warranty',
    'pag_register_user'  => 'register',
    'pag_userprivileges' => 'userprivileges',
    'pag_signaturemail'  => 'signaturemail',
];

function normalizarModulo($mod, $map){
    if(isset($map[$mod])) return $map[$mod];
    if(strpos($mod,'pag_') === 0) return false;
    return $mod;
}

switch ($method) {

    // ======================
    // LISTAR PRIVILEGIOS
    // ======================
    case 'GET':
        $sql = "
            SELECT * 
            FROM tb_pvlges AS tbp
            INNER JOIN tb_users AS tbu 
            ON tbp.ucoduser = tbu.ucoduser
        ";
        $res = $cn->query($sql);
        $rows = [];
        while($r = $res->fetch_assoc()){
            $rows[] = $r;
        }
        echo json_encode(['ok'=>true,'data'=>$rows]);
        break;

    // ======================
    // AGREGAR PRIVILEGIO
    // ======================
    case 'POST':
        $ucoduser = $data['ucoduser'] ?? '';
        $gup      = $data['gup'] ?? '';
        $tpeRaw   = $data['tpe'] ?? '';

        $tpe = normalizarModulo($tpeRaw,$map);
        if($tpe === false){
            echo json_encode(['ok'=>false,'msg'=>'Permiso inválido']);
            exit;
        }

        if($ucoduser=='' || $gup=='' || $tpe==''){
            echo json_encode(['ok'=>false,'msg'=>'Faltan datos']);
            exit;
        }

        $chk = $cn->prepare("
            SELECT 1 FROM tb_pvlges 
            WHERE gup=? AND tpe=? AND ucoduser=? LIMIT 1
        ");
        $chk->bind_param("sss",$gup,$tpe,$ucoduser);
        $chk->execute();
        $chk->store_result();

        if($chk->num_rows > 0){
            echo json_encode(['ok'=>false,'msg'=>'Privilegio ya existe']);
            exit;
        }

        $stmt = $cn->prepare("
            INSERT INTO tb_pvlges (gup,tpe,ucoduser)
            VALUES (?,?,?)
        ");
        $stmt->bind_param("sss",$gup,$tpe,$ucoduser);
        $stmt->execute();

        echo json_encode(['ok'=>true,'msg'=>'Privilegio concedido']);
        break;

    // ======================
    // QUITAR PRIVILEGIO
    // ======================
    case 'DELETE':
    $raw = json_decode(file_get_contents("php://input"), true);
    $del = $raw ?? [];
    
    $ucoduser = $del['ucoduser'] ?? '';
    $gup      = $del['gup'] ?? '';
    $tpe      = $del['tpe'] ?? '';

    if($ucoduser=='' || $gup=='' || $tpe==''){
        echo json_encode(['ok'=>false,'msg'=>'Faltan datos']);
        exit;
    }

    $stmt = $cn->prepare("
        DELETE FROM tb_pvlges 
        WHERE gup=? AND tpe=? AND ucoduser=?
    ");
    $stmt->bind_param("sss",$gup,$tpe,$ucoduser);
    $stmt->execute();

    echo json_encode(['ok'=>true,'msg'=>'Privilegio eliminado']);
    break;


    default:
        echo json_encode(['ok'=>false,'msg'=>'Método no soportado']);
}
