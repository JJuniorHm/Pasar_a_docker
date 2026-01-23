<?php 

include "../../icdes/Sconzton.php";

class export
{
    protected $db;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    // 🔒 PROTEGIDO CONTRA SQL INJECTION
    public function GetExportXLSX()
    {
        $sql = "
            SELECT 
                tbu.urazon AS tecnico,
                tbc.crazon AS cliente,
                tbc.ccodcli, tbc.cdireccion,
                tbc.ctelefono1, tbc.ctelefono2,
                tbw.wguidenumber, tbw.codigo,
                tbw.categoria, tbw.subcategoria,
                tbw.marca, tbw.descripcion,
                tbw.serialnumber, tbw.waccessories,
                tbw.wequipmentstatus, tbw.wguidetype,
                tbw.wvoucher, tbw.wprpc,
                tbw.wdiagnostic, tbw.wentrydate,
                tbw.wexitdate, tbw.wstage,
                tbw.wstate, tbw.wpriceproduct,
                tbw.wproblemsdetected,
                tbw.wconcludingremarks
            FROM tb_warranty AS tbw
            INNER JOIN tb_clientes AS tbc 
                ON tbw.ccodcli = tbc.ccodcli
            INNER JOIN tb_users AS tbu 
                ON tbw.ucoduser = tbu.ucoduser
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
