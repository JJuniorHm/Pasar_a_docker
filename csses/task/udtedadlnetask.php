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



class udtedadlnetask
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
    public function setCodUser($v) { $this->_coduser = trim($v); }
    public function setUserAra($v) { $this->_userara = trim($v); }


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

    // ✔ actualizar deadline
    public function UdteDadLne()
    {
        // obtener info
        $sql = "
            SELECT nmroid, etdo, fchareg
            FROM tb_gtor_tras
            WHERE nmroid = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        $item = $stmt->get_result()->fetch_assoc();
        if (!$item) return false;

        // timeline insert
        $sqlInsert = "
            INSERT INTO tb_lnatepo_tras (ucoduser, nmroid, ttlo, dccon, fchareg)
            VALUES (?, ?, 'Fecha Limite Ampliada', ?, ?)
        ";

        $dccon = $item['fchareg'] . ' -> ' . $this->_dtfchalmte;

        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bind_param(
            "ssss",
            $this->_coduser,
            $item['nmroid'],
            $dccon,
            $this->_dtfchalmte
        );
        $stmt->execute();

        // update deadline
        $sqlUpdate = "
            UPDATE tb_gtor_tras
            SET etdo = 'En Progreso',
                etdofchalmte = 'A Tiempo',
                fchalmte = ?
            WHERE nmroid = ?
        ";

        $stmt = $this->db->prepare($sqlUpdate);
        $stmt->bind_param("ss", $this->_dtfchalmte, $this->_numberid);
        $stmt->execute();

        return true;
    }

    // ✔ obtener timeline
    public function Get_TmeLne()
    {
        $sql = "
            SELECT *
            FROM tb_lnatepo_tras AS ltt
            INNER JOIN tb_users AS user
                ON ltt.ucoduser = user.ucoduser
            WHERE nmroid = ?
            ORDER BY fchareg DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
