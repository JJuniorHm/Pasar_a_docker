<?php

$ruta_original = "../../icdes/Sconzton.php";

if (file_exists($ruta_original)) {
    include $ruta_original;
} else if (file_exists("icdes/Sconzton.php")) {
    include "icdes/Sconzton.php";
} else {
    exit("El archivo de conexión no existe.");
}

class Add_Privileges
{
    protected $db;
    private $_platform;
    private $_module;
    private $_coduser;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser)  { $this->_coduser  = trim($coduser); }
    public function setModule($module)    { $this->_module   = trim($module); }
    public function setPlatform($platform){ $this->_platform = trim($platform); }

    // =========================
    // INSERT
    // =========================
    public function insert_UserPrivilege()
    {
        $sql = "
            INSERT INTO tb_pvlges (gup, tpe, ucoduser)
            VALUES (?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $this->_platform, $this->_module, $this->_coduser);

        return $stmt->execute();
    }

    // =========================
    // DELETE
    // =========================
    public function delete_UserPrivilege()
    {
        $sql = "
            DELETE FROM tb_pvlges 
            WHERE gup = ? 
              AND tpe = ? 
              AND ucoduser = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $this->_platform, $this->_module, $this->_coduser);

        return $stmt->execute();
    }

    // =========================
    // EXISTS
    // =========================
    public function exist_UserPrivilege()
    {
        $sql = "
            SELECT ucoduser 
            FROM tb_pvlges 
            WHERE gup = ? 
            AND tpe = ? 
            AND ucoduser = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $this->_platform, $this->_module, $this->_coduser);
        $stmt->execute();

        return $stmt->get_result();
    }

    // =========================
    // LIST
    // =========================
    public function tolist_UserPrivilege()
    {
        $sql = "
            SELECT * 
            FROM tb_pvlges AS tbp
            INNER JOIN tb_users AS tbu 
            ON tbp.ucoduser = tbu.ucoduser
        ";

        return $this->db->query($sql);
    }
}
?>
