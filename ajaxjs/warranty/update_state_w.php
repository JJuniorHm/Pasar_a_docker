<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    include "../../csses/warranty/update_state_w.php";

    $user = new user();
    $update_state_w = new update_state_w();

    if (empty($_SESSION['ucoduser'])) {
        echo json_encode([
            "sttus" => false,
            "message" => "Sesión expirada"
        ]);
        exit;
    }

    if ($user->getSession() === FALSE) {
        echo json_encode([
            "sttus" => false,
            "message" => "Debe iniciar sesión nuevamente"
        ]);
        exit;
    }

    $user->setCodUser($_SESSION['ucoduser']);
    $userInfo = $user->getUserInfo();

    /* ========================
       VALIDAR PARÁMETROS
    ========================= */

    $wguidenumber = $_POST['wguidenumber'] ?? '';
    $wstate       = $_POST['wstate'] ?? '';

    // guía: solo números
    $wguidenumber = preg_replace('/[^0-9]/', '', $wguidenumber);

    if ($wguidenumber === "") {
        echo json_encode([
            "sttus" => false,
            "message" => "Número de guía inválido"
        ]);
        exit;
    }

    // limpiar estado
    $wstate = trim($wstate);

    $statesAllowed = [
        "PENDIENTE",
        "PRODUCTO ENTREGADO",
        "EN TRÁMITE",
        "REVISIÓN",
        "DERIVAR AL PROVEEDOR",
        "CONFIRMAR GARANTÍA",
        "GESTIÓN INTERNA"
    ];

    if (!in_array(strtoupper($wstate), $statesAllowed)) {
        echo json_encode([
            "sttus" => false,
            "message" => "Estado no permitido"
        ]);
        exit;
    }

    /* ========================
       SET PARAMS
    ========================= */

    $update_state_w->SetUCodUser($userInfo['ucoduser']);
    $update_state_w->SetWGuideNumber($wguidenumber);
    $update_state_w->SetWState($wstate);

    $check_update_state_w = $update_state_w->update_state_w();

    if (!$check_update_state_w) {
        echo json_encode([
            "sttus" => false,
            "message" => "No se pudo actualizar el estado"
        ]);
        exit;
    }

    /* ========================
       TIMELINE
    ========================= */

    $get_tmelne = $update_state_w->GetTimeLine();

    $atrorfcha = null;
    $ltalneatepo = "";

    foreach ($get_tmelne as $key) {

        // escapamos contenido para evitar XSS
        $titulo = htmlspecialchars($key['wtl_title']);
        $descripcion = htmlspecialchars(
            substr(str_replace("&nbsp;", "", strip_tags($key['wtl_description'])), 0, 150)
        );

        $fchahra = $key['wtl_entrydate'];

        $nombre_mes = strftime("%B", strtotime($fchahra));
        $nombre_mes_mayuscula = ucfirst($nombre_mes);
        $fecha_formateada = strftime("%d de {$nombre_mes_mayuscula} %Y", strtotime($fchahra));
        $horaFormateada = date("g:i a", strtotime($fchahra));

        switch ($titulo) {
            case 'Etapa Cambiada':
                $etlodnstlttlo = 'dns-tl-ttlo';
                break;

            case 'Estado Cambiado':
                $etlodnstlttlo = 'dns-tl-ttlotraphcer';
                break;

            default:
                $etlodnstlttlo = 'dns-tl-ttlo';
                break;
        }

        if ($fecha_formateada !== $atrorfcha) {
            $ipmirfcha = '
                <div class="dns_date">
                    <span>' . $fecha_formateada . '</span>
                </div>';
            $atrorfcha = $fecha_formateada;
        } else {
            $ipmirfcha = '';
        }

        $ltalneatepo .= '
            <div class="dns_container_timeline">
                ' . $ipmirfcha . '
                <div class="dns_content_timeline">
                    <div class="dns_header">
                        <div class="dns_block1">
                            <div class="' . $etlodnstlttlo . '">
                                <span>' . $titulo . '</span>
                            </div>
                            <div class="dns-tl-fcha">
                                <span>' . $horaFormateada . '</span>
                            </div>
                        </div>
                        <div class="dns_block2">
                            <img src="imges/cdgopsnal/' . $key['ucoduser'] . '.webp">
                        </div>
                    </div>
                    <div class="dns_body">
                        <span>' . $descripcion . '</span>
                    </div>
                </div>
            </div>';
    }

    if ($ltalneatepo === "") {
        $ltalneatepo = '<div class="ctndornp my-2 p-2">Aún no hay cambios en el documento.</div>';
    }

    echo json_encode([
        'sttus' => true,
        'message' => $wguidenumber . ' ' . strtoupper($wstate),
        'timelinelist' => $ltalneatepo
    ]);
}
?>
