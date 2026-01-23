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
        $stmt = $this->db->prepare(
            "SELECT ucoduser, udni, urazon, udireccion, utelefono1,
                    upaterno, umaterno, unombre1, unombre2,
                    ucorreo, upassword, area
            FROM tb_users
            WHERE ucoduser = ?"
        );

        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_array(MYSQLI_ASSOC);
    }


    public function getListUserInfo()
    {
        $query = 'SELECT ucoduser,udni,urazon, udireccion, utelefono1, upaterno, umaterno, unombre1, unombre2, ucorreo, upassword, area FROM tb_users';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

}

?>