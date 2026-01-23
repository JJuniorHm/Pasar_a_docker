<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include "../../csses/task/udtekbantask.php";

$taskId = $_POST['taskId'] ?? null;
$etdo   = $_POST['etdo']   ?? null;
$nvel = $_POST['lvldlvry'] ?? null;

$user = new User();
$udtetask = new udtetask();

/* =========================
    MANEJO DE SESIÓN
========================= */

if (!empty($_SESSION['ucoduser'])) {
    $coduser = $_SESSION['ucoduser'];
}

if ($user->getSession() === FALSE) {
    ob_end_clean();
    echo json_encode([
        "sttus" => false,
        "msge"  => "Sesión expirada. Inicie sesión nuevamente."
    ]);
    exit;
}

if (isset($_GET['q'])) {
    $user->logout();
    ob_end_clean();
    echo json_encode([
        "sttus" => false,
        "msge"  => "Sesión finalizada."
    ]);
    exit;
}

$user->setCodUser($coduser);
$userInfo = $user->getUserInfo();

/* =========================
  VALIDACIÓN DE REQUEST
========================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!$taskId || !$etdo) {
        ob_end_clean();
        echo json_encode([
            "sttus" => false,
            "msge"  => "Datos incompletos para actualizar la tarea."
        ]);
        exit;
    }

    $udtetask->setNumberId($taskId);
    $check_rgter = $udtetask->CheckRgter();
    $dtprivilegios = $udtetask->GetPvlgos();

    /* =========================
      LÓGICA DE PRIVILEGIOS
    ========================= */


    // CREADOR Y RESPONSABLE
    if (
        $userInfo['ucoduser'] == $dtprivilegios['cadorid'] &&
        $userInfo['ucoduser'] == $dtprivilegios['rpsbleid']
    ) {

        if ($etdo == "Completado") {

            if ($check_rgter) {
                $udtetask->setCodUser($userInfo['ucoduser']);
                $udtetask->setdtRpsbleId($dtprivilegios['rpsbleid']);
                $udtetask->setdtEtdo($etdo);
                $udtetask->setdtLvelEfcecy($dtprivilegios['nvel']);

                $check = $udtetask->Udtekban_NoEficiency();

                ob_clean();
                echo json_encode([
                    'sttus' => $check ? true : false,
                    'msge'  => $check
                        ? 'Tarea actualizada'
                        : 'Error al actualizar la tarea, por favor vuelva a intentarlo'
                ]);
                exit;
            }

            ob_clean();
            echo json_encode([
                'sttus' => false,
                'msge'  => 'Error al actualizar la tarea, por favor vuelva a intentarlo'
            ]);
            exit;
        }

        // cambio normal
        if ($check_rgter) {
            $udtetask->setCodUser($userInfo['ucoduser']);
            $udtetask->setdtEtdo($etdo);

            $check = $udtetask->udtekban_Etpa();

            ob_clean();
            echo json_encode([
                'sttus' => $check ? true : false,
                'msge'  => $check
                    ? 'Tarea actualizada'
                    : 'Error al actualizar la tarea, por favor vuelva a intentarlo'
            ]);
            exit;
        }

        ob_clean();
        echo json_encode([
            'sttus' => false,
            'msge'  => 'Error al actualizar la tarea, por favor vuelva a intentarlo'
        ]);
        exit;
    }

    // SOLO CREADOR (no responsable)
    elseif (
        $userInfo['ucoduser'] == $dtprivilegios['cadorid'] &&
        $userInfo['ucoduser'] != $dtprivilegios['rpsbleid']
    ) {

        if ($etdo == "Completado") {

            if ($check_rgter) {
                $udtetask->setCodUser($userInfo['ucoduser']);
                $udtetask->setdtRpsbleId($dtprivilegios['rpsbleid']);
                $udtetask->setdtEtdo($etdo);
                $udtetask->setdtLvelEfcecy($dtprivilegios['nvel']);

                $check = $udtetask->Udtekban_EtpaCptdo();

                ob_clean();
                echo json_encode([
                    'sttus' => $check ? true : false,
                    'msge'  => $check
                        ? 'Tarea actualizada'
                        : 'Error al actualizar la tarea, por favor vuelva a intentarlo'
                ]);
                exit;
            }

            ob_clean();
            echo json_encode([
                'sttus' => false,
                'msge'  => 'Error al actualizar la tarea, por favor vuelva a intentarlo'
            ]);
            exit;
        }

        if ($check_rgter) {
            $udtetask->setCodUser($userInfo['ucoduser']);
            $udtetask->setdtEtdo($etdo);

            $check = $udtetask->udtekban_Etpa();

            ob_clean();
            echo json_encode([
                'sttus' => $check ? true : false,
                'msge'  => $check
                    ? 'Tarea actualizada'
                    : 'Error al actualizar la tarea, por favor vuelva a intentarlo'
            ]);
            exit;
        }

        ob_clean();
        echo json_encode([
            'sttus' => false,
            'msge'  => 'Error al actualizar la tarea, por favor vuelva a intentarlo'
        ]);
        exit;
    }

    // SOLO RESPONSABLE (no creador)
    elseif (
        $userInfo['ucoduser'] == $dtprivilegios['rpsbleid'] &&
        $userInfo['ucoduser'] != $dtprivilegios['cadorid']
    ) {

        if ($dtprivilegios['etdo'] == "Pendientes de Revisar" &&
            ($etdo == "Completado" || $etdo == "En Progreso")) {

            ob_clean();
            echo json_encode([
                'sttus' => false,
                'msge'  => 'Pide al creador que actualice la tarea, por favor.'
            ]);
            exit;
        }

        if ($dtprivilegios['etdo'] == "Completado" &&
            ($etdo == "Pendientes de Revisar" || $etdo == "En Progreso")) {

            ob_clean();
            echo json_encode([
                'sttus' => false,
                'msge'  => 'Solo el creador de la tarea puede cambiar la etapa a "En Progreso" o "Pendientes de Revisar".'
            ]);
            exit;
        }

        if ($dtprivilegios['etdo'] == "En Progreso" &&
            $etdo == "Completado") {

            ob_clean();
            echo json_encode([
                'sttus' => false,
                'msge'  => 'Solo el creador de la tarea puede cambiar la etapa a "Completado".'
            ]);
            exit;
        }

        if ($check_rgter) {
            $udtetask->setCodUser($userInfo['ucoduser']);
            $udtetask->setdtEtdo($etdo);

            $check = $udtetask->udtekban_Etpa();

            ob_clean();
            echo json_encode([
                'sttus' => $check ? true : false,
                'msge'  => $check
                    ? 'Tarea actualizada'
                    : 'Error al actualizar la tarea, por favor vuelva a intentarlo'
            ]);
            exit;
        }

        ob_clean();
        echo json_encode([
            'sttus' => false,
            'msge'  => 'Error al actualizar la tarea, por favor vuelva a intentarlo'
        ]);
        exit;
    }

    // Nadie con permisos
    else {

        ob_clean();
        echo json_encode([
            'sttus' => false,
            'msge'  => 'Solo el creador o responsable pueden cambiar la etapa de las tareas.'
        ]);
        exit;
    }
}

?>
