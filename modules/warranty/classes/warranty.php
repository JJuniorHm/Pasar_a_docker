<?php 
class warranty
{
    protected $db;
    private $_coduser;
    private $_dtnmroid;
    private $_dteqpo;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function Set_dtnmroid($dtnmroid){ 
        $this->_dtnmroid = trim($dtnmroid);
    }

    public function Set_dteqpo($dteqpo) { 
        $this->_dteqpo = trim($dteqpo);
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara);
    }

    // 🔒 PROTEGIDO
    public function GetList()
    {
        $sql = "
            SELECT 
                tbw.wnumberid,
                tbc.urazon AS client_name,
                tbu.urazon AS tech_name,
                tbw.guidesource, tbw.guidenumbersource,
                tbw.wendpoint, tbw.wguidenumber,
                tbw.codigo, tbw.categoria, tbw.subcategoria,
                tbw.descripcion, tbw.marca, tbw.serialnumber,
                tbw.waccessories, tbw.wequipmentstatus,
                tbw.wvoucher, tbw.wprpc, tbw.wdiagnostic,
                tbw.wsupplierpurchasedate, tbw.wentrydate,
                tbw.wsupplierentrydate, tbw.wsupplierstate,
                tbw.wproductlocation, tbw.wguidetype,
                tbw.wsupplierresolutiondate, tbw.wsupplierresolution,
                tbw.wentrycode, tbw.wstage, tbw.wstate,
                tbw.wpriceproduct, tbw.wequipmentoperation,
                tbw.wproblemsdetected, tbw.wconcludingremarks
            FROM tb_warranty AS tbw
            INNER JOIN tb_users AS tbc 
                ON tbw.ccodcli = tbc.ucoduser
            INNER JOIN tb_users AS tbu 
                ON tbw.ucoduser = tbu.ucoduser
            WHERE tbw.wstate <> 'PRODUCTO ENTREGADO'
            GROUP BY tbw.wguidenumber
            ORDER BY tbw.wguidenumber DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
