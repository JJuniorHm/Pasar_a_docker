<?php 

if (file_exists("../../icdes/Sconzton.php")) {
    require_once "../../icdes/Sconzton.php";
} elseif (file_exists("icdes/Sconzton.php")) {
    require_once "icdes/Sconzton.php";
} else {
    exit("No se encontró Sconzton.php");
}

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
                ucoduser, udni, urazon, udireccion, utelefono1,
                upaterno, umaterno, unombre1, unombre2,
                ucorreo, upassword, area
            FROM tb_users 
            WHERE ucoduser = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getListUserInfo()
    {
        $sql = "
            SELECT 
                ucoduser, udni, urazon, udireccion,
                utelefono1, upaterno, umaterno,
                unombre1, unombre2, ucorreo, area
            FROM tb_users
        ";

        return $this->db->query($sql);
    }
}
?>
