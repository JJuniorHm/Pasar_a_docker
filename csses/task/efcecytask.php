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

    public function logout() {
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


class efcecytask
{
    protected $db;
    private $_coduser;
    private $_userara;
    private $_datayear;
    private $_datamonth;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser) { $this->_coduser = trim($coduser); }
    public function setUserAra($userara) { $this->_userara = trim($userara); }
    public function setDataYear($datayear) { $this->_datayear = (int)$datayear; }
    public function setDataMonth($datamonth) { $this->_datamonth = (int)$datamonth; }

    public function GetInfoEfcecy()
    {
        $sql = "
            SELECT et.efcecy 
            FROM tb_efcecy_task et
            INNER JOIN tb_users u ON et.ucoduser = u.ucoduser
            WHERE u.ucoduser = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function GetInfoAreaEfcecy()
    {
        $sql = "
            SELECT et.ucoduser, us.unombre1, us.upaterno, us.area, et.efcecy
            FROM tb_efcecy_task et
            INNER JOIN tb_users us ON et.ucoduser = us.ucoduser
            WHERE us.area = ?
            AND MONTH(et.dtergter) = MONTH(CURRENT_DATE())
            AND YEAR(et.dtergter) = YEAR(CURRENT_DATE())
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_userara);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function get_ListResponsible()
    {
        $sql = "
            SELECT DISTINCT tbgt.rpsbleid, tbu.urazon
            FROM tb_users tbu
            INNER JOIN tb_gtor_tras tbgt ON tbu.ucoduser = tbgt.rpsbleid
            WHERE tbgt.cadorid = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function get_ListYear()
    {
        $sql = "
            SELECT DISTINCT YEAR(tbiet.dtergter) AS dtergter
            FROM tb_idctorefcecytask tbiet
            JOIN tb_gtor_tras tbgt ON tbiet.ucoduser = tbgt.rpsbleid
            WHERE tbgt.cadorid = ?
            ORDER BY dtergter DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function get_ListMonth()
    {
        $sql = "
            SELECT DISTINCT MONTH(dtergter) AS dtergter
            FROM tb_idctorefcecytask
            WHERE YEAR(dtergter) = YEAR(CURRENT_DATE())
            ORDER BY dtergter
        ";

        return $this->db->query($sql);
    }

    public function get_SelectYearListMonth()
    {
        $sql = "
            SELECT DISTINCT MONTH(tbiet.dtergter) AS months
            FROM tb_idctorefcecytask tbiet
            JOIN tb_gtor_tras tbgt ON tbiet.ucoduser = tbgt.rpsbleid
            WHERE tbgt.cadorid = ?
            AND YEAR(tbiet.dtergter) = ?
            ORDER BY months ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $this->_coduser, $this->_datayear);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function get_SelectMonthListResponsible()
    {
        $sql = "
            SELECT DISTINCT tbu.ucoduser, tbu.urazon
            FROM tb_users tbu
            JOIN tb_gtor_tras tbgt ON tbu.ucoduser = tbgt.rpsbleid
            JOIN tb_idctorefcecytask tbiet ON tbu.ucoduser = tbiet.ucoduser
            WHERE tbgt.cadorid = ?
            AND YEAR(tbiet.dtergter) = ?
            AND MONTH(tbiet.dtergter) = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sii", $this->_coduser, $this->_datayear, $this->_datamonth);
        $stmt->execute();

        return $stmt->get_result();
    }
}

?>
