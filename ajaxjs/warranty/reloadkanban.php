<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    include "../../csses/warranty/reloadkanban.php";
    $user = new user();
    $reloadkanban = new reloadkanban();
    if (empty($_SESSION['ucoduser'])) {
        echo json_encode([
            "sttus" => false,
            "html"  => "<div class='p-3'>Sesión expirada</div>"
        ]);
        exit;
    }
    if ($user->getSession() === FALSE) {
        echo json_encode([
            "sttus" => false,
            "html"  => "<div class='p-3'>Debe iniciar sesión</div>"
        ]);
        exit;
    }
    $coduser = $_SESSION['ucoduser'];
    $user->setCodUser($coduser);
    $userInfo = $user->getUserInfo();


    /* ========================
        BUSQUEDA SEGURA
    ========================= */
    $search = $_POST["sarchtask"] ?? "";
    $search = trim($search);
    // Permitimos letras / números / guiones
    $search = preg_replace('/[^A-Za-z0-9\- ]/', '', $search);
    $reloadkanban->EvarCdnaBqda($search);
    $reloadkanban->setCodUser($coduser);
    $listcards = $reloadkanban->GetListKanban();
    $ctinerclumns = [
        "GESTIÓN DE INTERNAMIENTO",
        "GESTIÓN DE ENVÍO: PROVEEDOR",
        "GESTIÓN DE RETORNO: PROVEEDOR",
        "GESTIÓN DE SALIDA"
    ];
    $ctentcolumns = [];
    foreach ($ctinerclumns as $estado) {
        $ctentcolumns[$estado] = [];
    }
    if ($listcards && $listcards->num_rows > 0) {
        while ($row = $listcards->fetch_assoc()) {
            // aseguramos wstage válido
            $stage = $row["wstage"] ?? "GESTIÓN DE INTERNAMIENTO";
            if (!isset($ctentcolumns[$stage])) {
                $ctentcolumns[$stage] = [];
            }
            $ctentcolumns[$stage][] = $row;
        }
    }
    $listkban = '
        <div id="dns_arrowleftkban" class="dns_arrowleftkban">
            <i class="bx bxs-chevrons-left"></i>
        </div>
        <div id="dns_boardkban" class="dns_boardkban">
    ';
    foreach ($ctentcolumns as $estado => $tasks) {
        // Reset por columna
        $count = 0;
        $totalsoles = 0;
        foreach ($tasks as $task) {
            $count++;
            $totalsoles += floatval($task["wpriceproduct"]);
        }
        $cloretdo = match ($estado) {
            "GESTIÓN DE INTERNAMIENTO"        => "#ff3000",
            "GESTIÓN DE ENVÍO: PROVEEDOR"     => "#0C2A98",
            "GESTIÓN DE RETORNO: PROVEEDOR"   => "#0C2A98",
            "GESTIÓN DE SALIDA"               => "#5AAC00",
            default                           => "#999"
        };
        $listkban .= '
            <div class="dns_clumnkban">
                <h6 class="text-truncate" style="background-color: '.$cloretdo.';">'.$estado.'</h6>
                <div class="d-flex justify-content-around">
                    <span>Cantidad: '.$count.'</span>
                    <span>Total S/'.number_format($totalsoles, 2).'</span>
                </div>
                <div class="dns_ctinerclumn" id="'.$estado.'">
        ';
        foreach ($tasks as $task) {
            $fecha_inicio_obj = new DateTime($task["wentrydate"]);
            $diferencia = $fecha_inicio_obj->diff(new DateTime())->days;
            $colorstate = 'style="border:1px dashed #7db047;"';
            if ($diferencia > 9 && $diferencia <= 20) {
                $colorstate = 'style="border:1px dashed #f0ce00;"';
            }
            if ($diferencia > 20) {
                $colorstate = 'style="border:1px dashed #ff1753;"';
            }
            $wstate = $task["wstate"] ?: "AÚN SIN ESTADO";
            $listkban .= '
                <div class="dns_cardkban" id="'.htmlspecialchars($task['wguidenumber']).'" '.$colorstate.'>
                    <div style="display:none;">'.$task["wguidenumber"].'</div>
                    <div class="dns_infotask">
                        '.htmlspecialchars($task["wendpoint"]).' -
                        '.str_pad($task["wguidenumber"], 8, '0', STR_PAD_LEFT).'
                    </div>
                    <span>Estado</span>
                    <div class="dns_infotask text-primary">'.htmlspecialchars($wstate).'</div>
                    <span>Responsable</span>
                    <div class="dns_infotask">'.htmlspecialchars(mb_substr($task["urazon"], 0, 50)).'</div>
                    <span>Cliente</span>
                    <div class="dns_infotask">'.htmlspecialchars(mb_substr($task["crazon"], 0, 50)).'</div>
                    <span>Producto</span>
                    <div class="dns_infotask">'.htmlspecialchars(mb_substr($task["descripcion"], 0, 50)).'</div>
                    <span>Fecha de Internamiento</span>
                    <div class="dns_infotask">'.htmlspecialchars($task["wentrydate"]).'</div>
                </div>';
        }
        $listkban .= '
                </div>
            </div>';
    }
    $listkban .= '
        <div class="dns_arrowrightkban" id="dns_arrowrightkban">
            <i class="bx bxs-chevrons-right"></i>
        </div>
    </div>';
    echo json_encode([
        'sttus' => true,
        'html'  => $listkban
    ]);
}
?>
