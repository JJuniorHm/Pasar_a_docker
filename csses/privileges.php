<?php

include "icdes/Sconzton.php";

class Validate_Privileges
{
    protected $db;
    private $_coduser;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    /**
     * Método genérico para validar privilegios
     */
    private function checkPrivilege($platform, $module)
    {
        $sql = "
            SELECT 1
            FROM tb_pvlges
            WHERE gup = ?
              AND tpe = ?
              AND ucoduser = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $platform, $module, $this->_coduser);
        $stmt->execute();

        return $stmt->get_result();
    }

    // ==============================
    // PRIVILEGIOS
    // ==============================

    public function validate_privileges() {
        return $this->checkPrivilege("gestorintegral", "tasks");
    }

    public function validate_privileges_in_tasks() {
        return $this->checkPrivilege("gestorintegral", "tasks");
    }

    public function validate_privileges_in_userprivileges() {
        return $this->checkPrivilege("gestorintegral", "userprivileges");
    }

    public function validate_privileges_in_signaturemail() {
        return $this->checkPrivilege("gestorintegral", "signaturemail");
    }

    public function validate_privileges_in_mainslider() {
        return $this->checkPrivilege("backofficeweb", "mainslider");
    }

    public function validate_privileges_in_warranty() {
        return $this->checkPrivilege("gestorintegral", "warranty");
    }

    public function validate_privileges_in_update_tb_prod() {
        return $this->checkPrivilege("backofficeweb", "update_tb_prod");
    }

    public function validate_privileges_in_register_user() {
        return $this->checkPrivilege("gestorintegral", "register");
    }
}

?>
