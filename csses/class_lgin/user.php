<?php
include "icdes/Sconzton.php";
class user
{

    protected $db;
    private $_coduser;
    private $_pword;
    public function setCodUser($coduser) { $this->_coduser = $coduser; }
    public function setPword($pword) { $this->_pword = $pword; }

    public function setUserAra($userara) { $this->_userara = $this->db->real_escape_string($userara) ;}

    public function __construct() {
    // Obtener la instancia única de la conexión
    $this->db = DBConnection::getInstance()->getConnection();
}

    //Do Login
        public function doLogin()
    {
        // 1 — consulta segura
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
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        if ($result->num_rows === 1) {
            if (!empty($user_data['upassword']) &&
                $this->verifyHash($this->_pword, $user_data['upassword'])) {
                $_SESSION['lgingtoritgral'] = TRUE;
                $_SESSION['ucoduser'] = $user_data['ucoduser'];
                // 2 — update seguro
                $stmt2 = $this->db->prepare(
                    "UPDATE tb_users SET u_datelogin = CURTIME() WHERE ucoduser = ?"
                );
                $stmt2->bind_param("s", $this->_coduser);
                $stmt2->execute();
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
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

//Get User Information
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

}

?>