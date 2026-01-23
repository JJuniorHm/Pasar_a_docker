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



class update_state_w
{
    protected $db;
    private $ucoduser;
    private $wguidenumber;
    private $wstate;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function SetUCodUser($ucoduser) { $this->ucoduser = $ucoduser; }
    public function SetWGuideNumber($wguidenumber) { $this->wguidenumber = $wguidenumber; }
    public function SetWState($wstate) { $this->wstate = $wstate; }


    // 🔒 TOTALMENTE PROTEGIDO
    public function update_state_w()
    {
        // 1️⃣ Verificar que exista la guía
        $sql = "
            SELECT 
                tbc.ucoduser, tbw.wguidenumber, tbw.wstate, 
                tbw.wstage, tbw.wguidetype
            FROM tb_warranty AS tbw
            INNER JOIN tb_users AS tbc 
                ON tbw.ucoduser = tbc.ucoduser
            WHERE tbw.wguidenumber = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->wguidenumber);
        $stmt->execute();

        $result = $stmt->get_result();
        $item   = $result->fetch_assoc();

        if ($result->num_rows !== 1) {
            return false;
        }

        // 2️⃣ Registrar timeline
        $sql = "
            INSERT INTO tb_warranty_timeline
                (ucoduser, wguidenumber, wguidetipe, wtl_title, wtl_description, wtl_entrydate)
            VALUES (?, ?, ?, 'Estado Cambiado', ?, NOW())
        ";

        $desc = $item['wstage'].": ".$item['wstate']." -> ".$this->wstate;

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $this->ucoduser,
            $item['wguidenumber'],
            $item['wguidetype'],
            $desc
        );
        $stmt->execute();


        // 3️⃣ Aplicar actualización según estado
        if ($this->wstate === "PRODUCTO ENTREGADO") {

            $sql = "
                UPDATE tb_warranty
                SET 
                    wstate = UPPER(?),
                    wstage = 'GESTIÓN DE SALIDA',
                    wexitdate = NOW()
                WHERE wguidenumber = ?
            ";

        } else {

            $sql = "
                UPDATE tb_warranty
                SET 
                    wstate = UPPER(?)
                WHERE wguidenumber = ?
            ";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $this->wstate, $this->wguidenumber);
        $stmt->execute();

        return true;
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
