<?php
include "../../icdes/Sconzton.php";
class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function setCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }
    public function setUserAra($userara) { $this->_userara = $this->db->real_escape_string($userara); }

        public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

    //Get Session 
    public function getSession() {
        if(!empty($_SESSION['lgingtoritgral']) && $_SESSION['lgingtoritgral']==TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    // Logout Method
    public function logout()
    {
        $_SESSION['lgingtoritgral'] = FALSE;
        unset($_SESSION);
        session_destroy();
    }

    public function getUserInfo()
    {
        $query = "SELECT ucoduser,udni,urazon, udireccion, utelefono1, upaterno, umaterno, unombre1, unombre2, ucorreo, upassword, area FROM tb_users WHERE ucoduser = ".$this->_coduser;
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }
}

class searchcodigo
{

    protected $db;
    private $_searchstring;

    public function setSearchString($searchstring) { $this->_searchstring = $this->db->real_escape_string($searchstring); }

        public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function GetList() // OBtener lista cadena busqueca
    {
        $keywords = explode(" ", $this->_searchstring);
        $keywords = array_filter($keywords);
        $whereClause = "";
        foreach ($keywords as $keyword) {
            $whereClause .= "(codigo LIKE '%$keyword%') AND ";
        }
        $whereClause = rtrim($whereClause, "AND ");
        if (!empty($whereClause)) {
            $query = 'SELECT * FROM tb_prod WHERE '.$whereClause.' ORDER BY codigo ASC LIMIT 12';
            $result = $this->db->query($query) or die($this->db->error);
            return $result;
        } else {
            return false;
        }
    }

}

?>