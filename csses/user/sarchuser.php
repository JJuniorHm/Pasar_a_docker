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
        return !empty($_SESSION['lgingtoritgral']);
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

class searchuser
{
    protected $db;
    private $_sarchstring;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setSarchString($sarchstring) {
        $this->_sarchstring = trim($sarchstring);
    }

    public function GetListCdeUser()
    {
        $keywords = explode(" ", $this->_sarchstring);
        $keywords = array_filter($keywords);

        if (empty($keywords)) return false;

        $sql = "
            SELECT 
                ucoduser, udni, urazon, udireccion,
                utelefono1, upaterno, umaterno,
                unombre1, unombre2, ucorreo, area
            FROM tb_users
            WHERE area <> ''
        ";

        $params = [];
        $types = "";

        foreach ($keywords as $kw) {
            $sql .= " AND (
                urazon LIKE ? 
                OR ucoduser LIKE ? 
                OR udni LIKE ?
            )";

            $kwLike = "%$kw%";

            $params[] = $kwLike;
            $params[] = $kwLike;
            $params[] = $kwLike;

            $types .= "sss";
        }

        $sql .= " ORDER BY urazon ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
