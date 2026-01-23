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



class newtask
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

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setdtCadorId($v){ $this->_dtcadorid = trim($v); }
    public function setdtRpsbleId($v){ $this->_dtrpsbleid = trim($v); }
    public function setdtNbreTra($v){ $this->_dtnbretra = trim($v); }
    public function setdtDccon($v){ $this->_dtdccon = trim($v); }
    public function setdtFchaLmte($v){ $this->_dtfchalmte = trim($v); }
    public function setdtLvelEfcecy($v){ $this->_dtlvelefcecy = trim($v); }

    public function setNumberId($v){ $this->_numberid = trim($v) ;}
    public function setCodUser($v) { $this->_coduser = trim($v); }
    public function setUserAra($v) { $this->_userara = trim($v); }


    public function savenewtask()
    {
        // calcular puntos
        $subtract = match ($this->_dtlvelefcecy) {
            "Bajo"    => 10,
            "Medio"   => 20,
            "Alto"    => 30,
            "Crítico" => 50,
            default   => 0
        };

        // ------------------------
        // INSERT tarea — seguro
        // ------------------------
        $sqlTask = "
            INSERT INTO tb_gtor_tras 
                (cadorid, rpsbleid, ttlo, dccon, fchareg, fchalmte, etdofchalmte, etdo, nvel)
            VALUES (?, ?, ?, ?, CURTIME(), ?, 'A Tiempo', 'En Progreso', ?)
        ";

        $stmt = $this->db->prepare($sqlTask);
        $stmt->bind_param(
            "ssssss",
            $this->_dtcadorid,
            $this->_dtrpsbleid,
            $this->_dtnbretra,
            $this->_dtdccon,
            $this->_dtfchalmte,
            $this->_dtlvelefcecy
        );

        $stmt->execute();
        $newidtask = $this->db->insert_id;

        // ------------------------
        // verificar registro eficiencia
        // ------------------------
        $sqlCheck = "
            SELECT 1 
            FROM tb_efcecy_task 
            WHERE ucoduser = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sqlCheck);
        $stmt->bind_param("s", $this->_dtrpsbleid);
        $stmt->execute();
        $exists = $stmt->get_result()->num_rows > 0;

        if ($exists) {

            // check mes/año actual
            $sqlMonth = "
                SELECT 1 
                FROM tb_efcecy_task
                WHERE ucoduser = ?
                AND MONTH(dtergter) = MONTH(NOW())
                AND YEAR(dtergter) = YEAR(NOW())
                LIMIT 1
            ";

            $stmt = $this->db->prepare($sqlMonth);
            $stmt->bind_param("s", $this->_dtrpsbleid);
            $stmt->execute();

            $existsMonth = $stmt->get_result()->num_rows > 0;

            if (!$existsMonth) {

                $sqlUpdate = "
                    UPDATE tb_efcecy_task
                    SET efcecy = 100, dtergter = NOW()
                    WHERE ucoduser = ?
                ";

                $stmt = $this->db->prepare($sqlUpdate);
                $stmt->bind_param("s", $this->_dtrpsbleid);
                $stmt->execute();
            }

        } else {

            // crear registro nuevo
            $sqlInsertEf = "
                INSERT INTO tb_efcecy_task (ucoduser, efcecy, dtergter)
                VALUES (?, 100, NOW())
            ";

            $stmt = $this->db->prepare($sqlInsertEf);
            $stmt->bind_param("s", $this->_dtrpsbleid);
            $stmt->execute();
        }

        return true;
    }
}
?>
