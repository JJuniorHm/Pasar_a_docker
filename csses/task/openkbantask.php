<?php
include "../../icdes/Sconzton.php";

class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara); 
    }

    //Get Session 
    public function getSession() {
        return !empty($_SESSION['lgingtoritgral']) && $_SESSION['lgingtoritgral'] === TRUE;
    }

    // Logout Method
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


class infotask
{
    protected $db;
    private $_coduser;
    private $_userara;
    private $_numberid;

    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setNumberId($numberid){ 
        $this->_numberid = trim($numberid); 
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara); 
    }

    public function getInfoTask()
    {
        $sql = "
            SELECT 
                cador.ucoduser AS cucoduser,
                cador.upaterno AS cupaterno,
                cador.umaterno AS cumaterno,
                cador.unombre1 AS cunombre1,

                rpsble.ucoduser AS rucoduser,
                rpsble.upaterno AS rupaterno,
                rpsble.umaterno AS rumaterno,
                rpsble.unombre1 AS runombre1,

                gt.nmroid,
                gt.cadorid,
                gt.rpsbleid,
                gt.ttlo,
                gt.dccon,
                gt.fchareg,
                gt.fchalmte,
                gt.etdofchalmte,
                gt.etdo,
                gt.nvel
            FROM tb_gtor_tras AS gt
            INNER JOIN tb_users AS cador ON gt.cadorid = cador.ucoduser
            INNER JOIN tb_users AS rpsble ON gt.rpsbleid = rpsble.ucoduser
            WHERE gt.nmroid = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_numberid);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }

    public function getTmeLne()
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
