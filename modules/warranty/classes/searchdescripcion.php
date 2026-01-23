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
    public function setCodUser($coduser) { 
        $this->_coduser = $this->db->real_escape_string($coduser); 
    }
    public function setUserAra($userara) { 
        $this->_userara = $this->db->real_escape_string($userara); 
    }
    public function getSession() {
        return !empty($_SESSION['lgingtoritgral']) && $_SESSION['lgingtoritgral'] === TRUE;
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



class searchdescripcion
{
    protected $db;
    private $_searchstring;
    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }
    public function setSearchString($searchstring) { 
        $this->_searchstring = $this->db->real_escape_string($searchstring); 
    }

    // 🔒 PROTEGIDO
    public function GetList()
    {
        $keywords = explode(" ", trim($this->_searchstring));
        $keywords = array_filter($keywords);
        if (empty($keywords)) {
            return false;
        }
        $sql = "
            SELECT *
            FROM tb_prod
            WHERE 1 = 1
        ";
        $params = [];
        $types  = "";
        foreach ($keywords as $k) {
            $sql .= " AND (descripcion LIKE ?)";
            $like = "%$k%";
            $params[] = $like;
            $types .= "s";
        }
        $sql .= " LIMIT 12";
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}

?>
