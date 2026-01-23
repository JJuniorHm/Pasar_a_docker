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

class addcmts
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
    private $_dtetdo;
    private $_dtcmts;

    public function setdtCadorId($dtcadorid){ $this->_dtcadorid = $this->db->real_escape_string($dtcadorid); }
    public function setdtRpsbleId($dtrpsbleid){ $this->_dtrpsbleid = $this->db->real_escape_string($dtrpsbleid); }
    public function setdtNbreTra($dtnbretra){ $this->_dtnbretra = $this->db->real_escape_string($dtnbretra); }
    public function setdtDccon($dtdccon){ $this->_dtdccon = $this->db->real_escape_string($dtdccon); }
    public function setdtFchaLmte($dtfchalmte){ $this->_dtfchalmte = $this->db->real_escape_string($dtfchalmte); }
    public function setdtLvelEfcecy($dtlvelefcecy){ $this->_dtlvelefcecy = $this->db->real_escape_string($dtlvelefcecy); }
    public function setdtEtdo($dtetdo){ $this->_dtetdo = $this->db->real_escape_string($dtetdo); }
    public function setCmts($dtcmts){ $this->_dtcmts = $this->db->real_escape_string($dtcmts); }

    public function setNumberId($numberid){ $this->_numberid = $this->db->real_escape_string($numberid) ;}
    public function setCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }
    public function setUserAra($userara) { $this->_userara = $this->db->real_escape_string($userara); }

    ppublic function __construct() {
    // Obtener la instancia única de la conexión
    $this->db = DBConnection::getInstance()->getConnection();
}

// ===============================
// ✔ CheckRgter — COMPROBAR REGISTRO
// ===============================
public function CheckRgter()
{
    $sql = "SELECT 1 FROM tb_gtor_tras WHERE nmroid = ? LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $this->_numberid);
    $stmt->execute();

    $result = $stmt->get_result();

    return ($result->num_rows === 1);
}

// ===============================
// ✔ GetPvlgos — OBTENER DATOS
// ===============================
public function GetPvlgos()
{
    $sql = "
        SELECT cadorid, rpsbleid, nvel
        FROM tb_gtor_tras
        WHERE nmroid = ?
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $this->_numberid);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

// ===============================
// ✔ AddCmts — AGREGAR COMENTARIO
// ===============================
public function AddCmts()
{
    // Primero validamos existencia
    $sql = "SELECT nmroid FROM tb_gtor_tras WHERE nmroid = ? LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $this->_numberid);
    $stmt->execute();

    $item = $stmt->get_result()->fetch_assoc();
    if (!$item) return false;

    // Insert del comentario
    $sqlInsert = "
        INSERT INTO tb_lnatepo_tras (ucoduser, nmroid, ttlo, dccon, fchareg)
        VALUES (?, ?, 'Comentario', ?, CURTIME())
    ";

    $stmt2 = $this->db->prepare($sqlInsert);
    $stmt2->bind_param("sss", $this->_coduser, $item['nmroid'], $this->_dtcmts);

    return $stmt2->execute();
}

// ===============================
// ✔ Get_TmeLne — OBTENER HISTORIAL
// ===============================
public function Get_TmeLne()
{
    $sql = "
        SELECT *
        FROM tb_lnatepo_tras AS ltt
        INNER JOIN tb_users AS user
            ON ltt.ucoduser = user.ucoduser
        WHERE nmroid = ?
        ORDER BY fchareg DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $this->_numberid);
    $stmt->execute();

    return $stmt->get_result();
}


}

?>