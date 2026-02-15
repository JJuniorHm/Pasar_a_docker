<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/Sconzton.php";

class Lgin
{
    protected $db;
    private $_coduser;
    private $_pword;

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setPword($pword) { 
        $this->_pword = $pword; 
    }

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    // =====================
    // LOGIN
    // =====================
    public function doLogin()
    {     
        if (empty($this->_coduser) || empty($this->_pword)) {
            return false;
        }

        // consulta segura
        $stmt = $this->db->prepare("
            SELECT ucoduser, upassword
            FROM tb_users 
            WHERE ucoduser = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows !== 1) {
            return false;
        }

        $user_data = $result->fetch_assoc();

        if (!empty($user_data['upassword']) &&
            password_verify($this->_pword, $user_data['upassword'])) 
        {
            // regenerate session
            session_regenerate_id(true);

            $_SESSION['lgingtoritgral'] = true;
            $_SESSION['ucoduser'] = $user_data['ucoduser'];

            // UPDATE LOGIN usando prepared
            $stmt2 = $this->db->prepare("
                UPDATE tb_users 
                SET u_datelogin = NOW()
                WHERE ucoduser = ?
            ");

            $stmt2->bind_param("s", $this->_coduser);
            $stmt2->execute();

            return [
                'ucoduser' => $user_data['ucoduser']
            ];
        }

        return false;
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
        if (empty($this->_coduser)) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT 
                ucoduser, udni, urazon, udireccion, 
                utelefono1, upaterno, umaterno, 
                unombre1, unombre2, ucorreo, area
            FROM tb_users 
            WHERE ucoduser = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : false;
    }
}
