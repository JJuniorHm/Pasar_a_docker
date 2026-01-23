<?php
include "../../icdes/Sconzton.php";

class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara); 
    }

    public function getSession() {
        return !empty($_SESSION['lgingtoritgral']) && $_SESSION['lgingtoritgral'] === TRUE;
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    public function getUserInfo()
    {
        $sql = "
            SELECT 
                ucoduser, udni, urazon, udireccion, 
                utelefono1, upaterno, umaterno,
                unombre1, unombre2, ucorreo, upassword, area
            FROM tb_users
            WHERE ucoduser = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}



class carddetails
{
    protected $db;
    private $_coduser;
    private $_userara;
    private $wguidenumber;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function SetWGuideNumber($wguidenumber){ 
        $this->wguidenumber = trim($wguidenumber); 
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara); 
    }

    public function GetCardDetails()
    {
        $sql = "
            SELECT 
                tbw.wnumberid, tbc.ccodcli, tbc.crazon, 
                tbc.ctelefono1, tbc.ctelefono2, tbc.cdireccion,
                tbu.urazon, tbw.guidesource, tbw.guidenumbersource,
                tbw.wendpoint, tbw.wguidenumber, tbw.codigo,
                tbw.categoria, tbw.subcategoria, tbw.descripcion,
                tbw.marca, tbw.serialnumber, tbw.waccessories,
                tbw.wequipmentstatus, tbw.wvoucher, tbw.wprpc,
                tbw.wdiagnostic, tbw.wsupplierpurchasedate,
                tbw.wentrydate, tbw.wsupplierentrydate,
                tbw.wsupplierstate, tbw.wproductlocation,
                tbw.wguidetype, tbw.wsupplierresolutiondate,
                tbw.wsupplierresolution, tbw.wentrycode,
                tbw.wstage, tbw.wstate, tbw.wpriceproduct,
                tbw.wequipmentoperation, tbw.wproblemsdetected,
                tbw.wconcludingremarks
            FROM tb_warranty AS tbw
            INNER JOIN tb_clientes AS tbc ON tbw.ccodcli = tbc.ccodcli
            INNER JOIN tb_users   AS tbu ON tbw.ucoduser = tbu.ucoduser
            WHERE tbw.wguidenumber = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->wguidenumber);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }

    public function GetTimeLine()
    {
        $sql = "
            SELECT *
            FROM tb_warranty_timeline AS tbwtl
            INNER JOIN tb_users AS tbu 
                ON tbwtl.ucoduser = tbu.ucoduser
            WHERE tbwtl.wguidenumber = ?
            ORDER BY tbwtl.wtl_entrydate DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->wguidenumber);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
