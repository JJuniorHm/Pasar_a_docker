<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "../../csses/task/efcecytask.php";

    $efcecytask = new efcecytask();

    if (!empty($_SESSION['ucoduser'])) {
        $coduser = $_SESSION['ucoduser'];
    }

    $efcecytask->setCodUser($coduser);
    $efcecytask->setDataYear($_POST['selectyear'] ?? null);
    $efcecytask->setDataMonth($_POST['selectmonth'] ?? null);

    // =======================
    // LISTAR MESES
    // =======================
    if ($_POST["action"] == "listmonths") {

        $listoption = '<option value="">Seleccione el Mes.</option>';

        $get_SelectYearListMonth = $efcecytask->get_SelectYearListMonth();

        foreach ($get_SelectYearListMonth as $key) {
            $listoption .= '<option value="'.$key['months'].'">'.$key['months'].'</option>';
        }

        echo $listoption;
    }

    // =======================
    // LISTAR RESPONSABLES
    // =======================
    if ($_POST["action"] == "listresponsible") {

        $listoption = '<option value="">Seleccione al Responsable.</option>';

        $get_SelectMonthListResponsible = $efcecytask->get_SelectMonthListResponsible();

        foreach ($get_SelectMonthListResponsible as $key) {
            $listoption .= '<option value="'.$key['ucoduser'].'">'.$key['urazon'].'</option>';
        }

        echo $listoption;
    }
}
?>
