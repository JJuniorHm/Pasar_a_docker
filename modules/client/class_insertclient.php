<?php

include "../../icdes/Sconzton.php";

class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara); 
    }

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
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

class class_insertClient
{
    protected $db;

    private $ccodcli;
    private $crazon;
    private $cnombre1;
    private $cnombre2;
    private $cpaterno;
    private $cmaterno;
    private $cdireccion;
    private $ctelefono1;
    private $ctelefono2;
    private $ccorreo;

    public function SetCCodCli($ccodcli) { $this->ccodcli = trim($ccodcli); }
    public function SetCRazon($crazon) { $this->crazon = trim($crazon); }
    public function SetCNombre1($cnombre1) { $this->cnombre1 = trim($cnombre1); }
    public function SetCNombre2($cnombre2) { $this->cnombre2 = trim($cnombre2); }
    public function SetCPaterno($cpaterno) { $this->cpaterno = trim($cpaterno); }
    public function SetCMaterno($cmaterno) { $this->cmaterno = trim($cmaterno); }
    public function SetCDireccion($cdireccion) { $this->cdireccion = trim($cdireccion); }
    public function SetCTelefono1($ctelefono1) { $this->ctelefono1 = trim($ctelefono1); }
    public function SetCTelefono2($ctelefono2) { $this->ctelefono2 = trim($ctelefono2); }
    public function SetCCorreo($ccorreo) { $this->ccorreo = trim($ccorreo); }

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function insertClient()
    {
        $query_check = 'SELECT ccodcli FROM tb_clientes WHERE ccodcli = ?';

        $stmt_check = $this->db->prepare($query_check);
        $stmt_check->bind_param('s', $this->ccodcli);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows == 0) {

            $query_insert = "
                INSERT INTO tb_clientes
                (ccodcli, crazon, cnombre1, cnombre2, cpaterno, cmaterno,
                cdireccion, ctelefono1, ctelefono2, ccorreo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt_insert = $this->db->prepare($query_insert);

            $stmt_insert->bind_param(
                'ssssssssss',
                $this->ccodcli,
                $this->crazon,
                $this->cnombre1,
                $this->cnombre2,
                $this->cpaterno,
                $this->cmaterno,
                $this->cdireccion,
                $this->ctelefono1,
                $this->ctelefono2,
                $this->ccorreo
            );

            return $stmt_insert->execute();
        }

        return false;
    }
}

?>
