<?php

require $_SERVER['DOCUMENT_ROOT'] . "/includes/Sconzton.php";
require "../../csses/user/user.php";

header("Content-Type: application/json");

try {

    // =========================
    // DATA
    // =========================
    $coduser = $_POST["listresponsible"] ?? ($_SESSION['ucoduser'] ?? null);
    $year    = (int) ($_POST['slcnaraño'] ?? 0);
    $month   = (int) ($_POST['slcnarmes'] ?? 0);

    if (!$coduser || !$year || !$month) {
        echo json_encode([
            "status"  => false,
            "message" => "Faltan parámetros para generar el gráfico."
        ]);
        exit;
    }

    // Conexión GLOBAL
    $db = DBConnection::getInstance()->getConnection();

    $sql = "
        SELECT efcecy, DAY(dtergter) AS fcha_dia
        FROM tb_idctorefcecytask
        WHERE ucoduser = ?
        AND YEAR(dtergter) = ?
        AND MONTH(dtergter) = ?
        ORDER BY fcha_dia ASC
    ";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("sii", $coduser, $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "dtergter" => "D" . $row["fcha_dia"],
            "efcecy"   => (float) $row["efcecy"]
        ];
    }

    echo json_encode([
        "status" => true,
        "data"   => $data
    ]);
    exit;

} catch (Throwable $e) {

    echo json_encode([
        "status"  => false,
        "message" => "Error interno",
        "debug"   => $e->getMessage()
    ]);
    exit;
}
