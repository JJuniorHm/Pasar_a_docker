<?php
include "../../../includes/Sconzton.php";

class user
{
    protected $db;
    private $ucoduser;
    private $_userara;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($ucoduser) { 
        $this->ucoduser = $ucoduser;
    }

    public function setUserAra($userara) { 
        $this->_userara = $userara;
    }

    public function getSession() {
        return !empty($_SESSION['lgingtoritgral']) && $_SESSION['lgingtoritgral']==TRUE;
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    // 🔒 PROTEGIDO
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
        $stmt->bind_param("s", $this->ucoduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    }
}



class update_service_w
{
    protected $db;
    private $ucoduser;
    private $wguidenumber;
    private $wstate;
    private $waccessories;
    private $wprpc;
    private $wequipmentstatus;
    private $wdiagnostic;
    private $wproblemsdetected;
    private $wconcludingremarks;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function SetUCodUser($ucoduser) { $this->ucoduser = $ucoduser; }
    public function SetWGuideNumber($wguidenumber) { $this->wguidenumber = $wguidenumber; }
    public function SetWState($wstate) { $this->wstate = $wstate; }

    public function setWAccessories($waccessories){ $this->waccessories = $waccessories; }
    public function setWPRPC($wprpc){ $this->wprpc = $wprpc; }
    public function setWEquipmentStatus($wequipmentstatus){ $this->wequipmentstatus = $wequipmentstatus; }
    public function setWDiagnostic($wdiagnostic){ $this->wdiagnostic = $wdiagnostic; }
    public function setWProblemsDetected($wproblemsdetected){ $this->wproblemsdetected = $wproblemsdetected; }
    public function setWConcludingRemarks($wconcludingremarks){ $this->wconcludingremarks = $wconcludingremarks; }


    // 🔒 TOTALMENTE PROTEGIDO
    public function update_service_w()
    {
        // 1️⃣ Verificar registro
        $sql = "
            SELECT tbc.ucoduser, tbw.wguidenumber, tbw.wstate, tbw.wstage, tbw.wguidetype
            FROM tb_warranty AS tbw
            INNER JOIN tb_users AS tbc ON tbw.ucoduser = tbc.ucoduser
            WHERE tbw.wguidenumber = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->wguidenumber);
        $stmt->execute();

        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if ($result->num_rows !== 1) {
            return false;
        }

        // 2️⃣ Actualizar datos
        $sql = "
            UPDATE tb_warranty
            SET 
                waccessories = ?,
                wprpc = ?,
                wequipmentstatus = ?,
                wdiagnostic = ?,
                wproblemsdetected = ?,
                wconcludingremarks = ?
            WHERE wguidenumber = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "sssssss",
            $this->waccessories,
            $this->wprpc,
            $this->wequipmentstatus,
            $this->wdiagnostic,
            $this->wproblemsdetected,
            $this->wconcludingremarks,
            $this->wguidenumber
        );

        $stmt->execute();

        return true;
    }


    public function GetTimeLine()
    {
        $sql = "
            SELECT *
            FROM tb_warranty_timeline AS tbwtl
            INNER JOIN tb_users AS tbu ON tbwtl.ucoduser = tbu.ucoduser
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
