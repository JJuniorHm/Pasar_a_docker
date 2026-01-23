<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/Comsitec/includes/Sconzton.php";
    $cn = DBConnection::getInstance()->getConnection();

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents("php://input"), true);
    $data = array_merge($_POST, $input ?? []);

    // Estados válidos según tu sistema
    $estadosValidos = [
    'En Progreso',
    'Pendientes de Revisar',
    'Completado'
    ];

    switch ($method) {

        // =========================
        // LISTAR TAREAS
        // =========================
        case 'GET':
            $res = $cn->query(
            "SELECT * FROM tb_gtor_tras 
            WHERE etdo <> 'ANULADO'
            ORDER BY nmroid DESC"
            );

            $rows = [];
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }

            echo json_encode(['ok'=>true,'data'=>$rows]);
            break;

        // =========================
        // CREAR TAREA
        // =========================
        case 'POST':
            $cadorid  = $data['cadorid'] ?? '';
            $rpsbleid = $data['rpsbleid'] ?? '';
            $ttlo     = $data['ttlo'] ?? '';
            $dccon    = $data['dccon'] ?? '';
            $fchalmte = $data['fchalmte'] ?? null;
            $etdo     = $data['etdo'] ?? 'En Progreso';
            $nvel     = $data['nvel'] ?? 'Normal';

            if($cadorid=='' || $rpsbleid=='' || $ttlo==''){
                echo json_encode(['ok'=>false,'msg'=>'Faltan datos obligatorios']);
                exit;
            }

            if(!in_array($etdo, $estadosValidos)){
                echo json_encode(['ok'=>false,'msg'=>'Estado no válido']);
                exit;
            }

            $stmt = $cn->prepare(
            "INSERT INTO tb_gtor_tras 
            (cadorid,rpsbleid,ttlo,dccon,fchareg,fchalmte,etdofchalmte,etdo,nvel)
            VALUES (?,?,?,?,NOW(),?, 'A Tiempo',?,?)"
            );

            $stmt->bind_param("sssssss",
            $cadorid,
            $rpsbleid,
            $ttlo,
            $dccon,
            $fchalmte,
            $etdo,
            $nvel
            );

            $stmt->execute();

            echo json_encode(['ok'=>true,'msg'=>'Tarea creada']);
            break;

        // =========================
        // EDITAR / CAMBIAR ESTADO
        // =========================
        case 'PUT':
            $nmroid   = $data['nmroid'] ?? 0;
            $rpsbleid = $data['rpsbleid'] ?? '';
            $ttlo     = $data['ttlo'] ?? '';
            $dccon    = $data['dccon'] ?? '';
            $fchalmte = $data['fchalmte'] ?? null;
            $etdo     = $data['etdo'] ?? '';
            $nvel     = $data['nvel'] ?? '';

            if(!$nmroid){
                echo json_encode(['ok'=>false,'msg'=>'Falta ID']);
                exit;
            }

            if($etdo !== '' && !in_array($etdo, $estadosValidos)){
                echo json_encode(['ok'=>false,'msg'=>'Estado no válido']);
                exit;
            }

            $stmt = $cn->prepare(
            "UPDATE tb_gtor_tras 
            SET rpsbleid=?, ttlo=?, dccon=?, fchalmte=?, etdo=?, nvel=?
            WHERE nmroid=?"
            );

            $stmt->bind_param("ssssssi",
            $rpsbleid,
            $ttlo,
            $dccon,
            $fchalmte,
            $etdo,
            $nvel,
            $nmroid
            );

            $stmt->execute();

            echo json_encode(['ok'=>true,'msg'=>'Tarea actualizada']);
            break;

        // =========================
        // ANULAR TAREA (NO BORRAR)
        // =========================
        case 'DELETE':
            parse_str(file_get_contents("php://input"), $del);
            $nmroid = $del['nmroid'] ?? 0;

            if(!$nmroid){
                echo json_encode(['ok'=>false,'msg'=>'Falta ID']);
                exit;
            }

            $stmt = $cn->prepare(
            "UPDATE tb_gtor_tras SET etdo='ANULADO' WHERE nmroid=?"
            );
            $stmt->bind_param("i",$nmroid);
            $stmt->execute();

            echo json_encode(['ok'=>true,'msg'=>'Tarea anulada']);
            break;

        default:
            echo json_encode(['ok'=>false,'msg'=>'Método no soportado']);
    }
