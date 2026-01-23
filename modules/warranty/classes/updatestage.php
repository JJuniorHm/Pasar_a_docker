<?php
include "../../../includes/Sconzton.php";

class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function SetUCodUser($coduser) { 
        $this->_coduser = $this->db->real_escape_string($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = $this->db->real_escape_string($userara); 
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
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    }
}



class updatestage
{
    protected $db;
    private $ucoduser;
    private $wguidenumber;
    private $wstage;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function SetUCodUser($ucoduser) { 
        $this->ucoduser = $this->db->real_escape_string($ucoduser); 
    }

    public function SetWGuideNumber($wguidenumber) { 
        $this->wguidenumber = $this->db->real_escape_string($wguidenumber); 
    }

    public function SetWStage($wstage){ 
        $this->wstage = $this->db->real_escape_string($wstage); 
    }

    // 🔒 PROTEGIDO
    public function UpdateStage()
    {
        // 1️⃣ Obtener datos
        $sql = "
            SELECT tbc.ccodcli, tbw.wguidenumber, tbw.wguidetype, tbw.wstage, tbw.wstate
            FROM tb_warranty AS tbw
            INNER JOIN tb_clientes AS tbc ON tbw.ccodcli = tbc.ccodcli
            WHERE tbw.wguidenumber = ?
              AND tbw.wguidetype = 'Cliente'
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->wguidenumber);
        $stmt->execute();

        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        $count_row = $result->num_rows;

        if ($count_row === 1)
        {
            // 2️⃣ Insertar timeline
            $sql = "
                INSERT INTO tb_warranty_timeline
                    (ucoduser, wguidenumber, wguidetipe, wtl_title, wtl_description, wtl_entrydate)
                VALUES (?, ?, ?, 'Etapa Cambiada', ?, CURTIME())
            ";

            $description = $item['wstage'].' -> '.$this->wstage;

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param(
                "ssss",
                $this->ucoduser,
                $item['wguidenumber'],
                $item['wguidetype'],
                $description
            );
            $stmt->execute();

            // 3️⃣ Actualizar stage
            $sql = "
                UPDATE tb_warranty
                SET wstage = ?, wstate = ''
                WHERE wguidenumber = ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ss", $this->wstage, $this->wguidenumber);
            $stmt->execute();
            return true;
        }
        return false;
    }
}

?>
