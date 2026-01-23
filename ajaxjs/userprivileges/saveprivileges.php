<?php

include "../../csses/userprivileges/userprivileges.php";

$Add_Privileges = new Add_Privileges();

// =========================
// NORMALIZAR MÓDULO (CLAVE)
// =========================
$map = [
    'pag_taskmnger'      => 'tasks',
    'pag_warranty'       => 'warranty',
    'pag_register_user'  => 'register',
    'pag_userprivileges' => 'userprivileges',
    'pag_signaturemail'  => 'signaturemail',
];

$module = $_POST['listgroupplatform'] ?? '';

if (isset($map[$module])) {
    $module = $map[$module];
}

// Bloquear cualquier pag_*
if (strpos($module, 'pag_') === 0) {
    echo json_encode(['data' => 'Permiso inválido']);
    exit;
}

// =========================
// SETEO CORRECTO
// =========================
$Add_Privileges->setCodUser($_POST['dtcdeuser']);
$Add_Privileges->setModule($module);
$Add_Privileges->setPlatform($_POST['groupplatform']);

// =========================
// PROCESO
// =========================
$checkexist = $Add_Privileges->exist_UserPrivilege();
if ($checkexist->num_rows == 1) {
    echo json_encode(['data' => 'No hay necesidad de volver a dar los privilegios..']);
    exit;
}

$check = $Add_Privileges->insert_UserPrivilege();
if ($check) {

    $tolist = $Add_Privileges->tolist_UserPrivilege();
    $table_userprivileges = '
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Colaborador</th>
                    <th>Plataforma y Módulo</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach ($tolist as $key) {
        $table_userprivileges .= '
            <tr>
                <td>
                    <div>'.$key['area'].'</div>
                    <div>'.$key['unombre1'].' '.$key['upaterno'].'</div>
                </td>
                <td>
                    <div>'.$key['gup'].'</div>
                    <div>'.$key['tpe'].'</div>
                </td>
                <td>
                    <button class="dns_deleteprivilege"
                        data-platform="'.$key['gup'].'"
                        data-mdle="'.$key['tpe'].'"
                        data-ucoduser="'.$key['ucoduser'].'">
                        <i class="bx bxs-trash"></i>
                    </button>
                </td>
            </tr>
        ';
    }

    $table_userprivileges .= '
            </tbody>
        </table>
    ';

    echo json_encode(['data' => 'Privilegio Concedido.', 'html' => $table_userprivileges]);
    exit;
}

echo json_encode(['data' => 'Ocurrió un error al dar privilegios.']);
exit;
