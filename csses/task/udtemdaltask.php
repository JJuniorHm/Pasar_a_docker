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
            SELECT ucoduser, udni, urazon, udireccion,
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



class udtemdaltask
{
    protected $db;

    private $_coduser;
    private $_userara;
    private $_numberid;

    private $_dtcadorid;
    private $_dtrpsbleid;
    private $_dtnbretra;
    private $_dtdccon;
    private $_dtfchalmte;
    private $_dtlvelefcecy;
    private $_dtetdo;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setdtCadorId($v){ $this->_dtcadorid = trim($v); }
    public function setdtRpsbleId($v){ $this->_dtrpsbleid = trim($v); }
    public function setdtNbreTra($v){ $this->_dtnbretra = trim($v); }
    public function setdtDccon($v){ $this->_dtdccon = trim($v); }
    public function setdtFchaLmte($v){ $this->_dtfchalmte = trim($v); }
    public function setdtLvelEfcecy($v){ $this->_dtlvelefcecy = trim($v); }
    public function setdtEtdo($v){ $this->_dtetdo = trim($v); }

    public function setNumberId($v){ $this->_numberid = trim($v); }
    public function setCodUser($v){ $this->_coduser = trim($v); }
    public function setUserAra($v){ $this->_userara = trim($v); }


    // ✔ comprobar registro
    public function CheckRgter()
    {
        $sql = "SELECT 1 FROM tb_gtor_tras WHERE nmroid = ? LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        return $stmt->get_result()->num_rows === 1;
    }

    // ✔ obtener privilegios
    public function GetPvlgos()
    {
        $sql = "
            SELECT cadorid, rpsbleid, nvel
            FROM tb_gtor_tras
            WHERE nmroid = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // ✔ etapa completada con puntos
    public function Udtekban_EtpaCptdo()
    {
        $sql = "
            SELECT nmroid, etdo
            FROM tb_gtor_tras
            WHERE nmroid = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        $item = $stmt->get_result()->fetch_assoc();
        if (!$item) return false;

        // puntos
        $addefcecy = match ($this->_dtlvelefcecy) {
            "Bajo"    => round(10/4),
            "Medio"   => round(20/4),
            "Alto"    => round(30/4),
            "Crítico" => round(50/4),
            default   => 0
        };

        // timeline
        $sqlInsert = "
            INSERT INTO tb_lnatepo_tras (ucoduser, nmroid, ttlo, dccon, fchareg)
            VALUES (?, ?, 'Etapa Cambiada', ?, NOW())
        ";

        $dc = $item['etdo'].' -> '.$this->_dtetdo;

        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bind_param("sss", $this->_coduser, $item['nmroid'], $dc);
        $stmt->execute();

        // update etapa
        $sqlStage = "
            UPDATE tb_gtor_tras
            SET etdo = ?
            WHERE nmroid = ?
        ";

        $stmt = $this->db->prepare($sqlStage);
        $stmt->bind_param("ss", $this->_dtetdo, $this->_numberid);
        $stmt->execute();

        // eficiencia
        $sqlEf = "
            UPDATE tb_efcecy_task
            SET efcecy = CASE 
                WHEN (efcecy + ?) > 100 THEN 100 
                ELSE (efcecy + ?) 
            END
            WHERE ucoduser = ?
        ";

        $stmt = $this->db->prepare($sqlEf);
        $stmt->bind_param("iis", $addefcecy, $addefcecy, $this->_dtrpsbleid);
        $stmt->execute();

        // drop event (seguro)
        $sqlDrop = "DROP EVENT IF EXISTS nbertask_".$this->_numberid;
        $this->db->query($sqlDrop);

        return true;
    }

    // ✔ etapa sin puntos
    public function udtekban_Etpa()
    {
        $sql = "
            SELECT nmroid, etdo
            FROM tb_gtor_tras
            WHERE nmroid = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        $item = $stmt->get_result()->fetch_assoc();
        if (!$item) return false;

        $sqlInsert = "
            INSERT INTO tb_lnatepo_tras (ucoduser, nmroid, ttlo, dccon, fchareg)
            VALUES (?, ?, 'Etapa Cambiada', ?, NOW())
        ";

        $dc = $item['etdo'].' -> '.$this->_dtetdo;

        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bind_param("sss", $this->_coduser, $item['nmroid'], $dc);
        $stmt->execute();

        $sqlUpdate = "
            UPDATE tb_gtor_tras
            SET etdo = ?
            WHERE nmroid = ?
        ";

        $stmt = $this->db->prepare($sqlUpdate);
        $stmt->bind_param("ss", $this->_dtetdo, $this->_numberid);
        $stmt->execute();

        $sqlDrop = "DROP EVENT IF EXISTS nbertask_".$this->_numberid;
        $this->db->query($sqlDrop);

        return true;
    }
}
?>
