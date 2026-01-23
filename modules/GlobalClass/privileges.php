<?php

$ruta_original = "includes/Sconzton.php";
$ruta_2 = "../../includes/Sconzton.php";

if (file_exists($ruta_original)) {
    include $ruta_original;
} elseif (file_exists($ruta_2)) {
    include $ruta_2;
} else {
    $ruta_alternativa = "../../../includes/Sconzton.php";
    if (file_exists($ruta_alternativa)) {
        include $ruta_alternativa;
    } else {
        echo "El archivo no se encontró en ninguna de las rutas especificadas.";
    }
}

class Privileges
{
    protected $db;
    private $_coduser;

    public function setCodUser($coduser) {
        $this->_coduser = trim($coduser);
    }

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    private function checkPrivilege($group, $type)
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
        $stmt->bind_param("sss", $group, $type, $this->_coduser);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function validate_privileges() {
        return $this->checkPrivilege("gestorintegral", "tasks");
    }

    public function validate_privileges_in_tasks() {
        return $this->checkPrivilege("gestorintegral", "tasks");
    }

    public function validate_privileges_in_userprivileges() {
        return $this->checkPrivilege("gestorintegral", "userprivileges");
    }

    public function validate_privileges_in_mainslider() {
        return $this->checkPrivilege("backofficeweb", "mainslider");
    }

    public function validate_privileges_in_orders() {
        return $this->checkPrivilege("backofficeweb", "orders");
    }

    public function validate_privileges_in_warranty() {
        return $this->checkPrivilege("gestorintegral", "warranty");
    }

    public function validate_privileges_in_specifications() {
        return $this->checkPrivilege("backofficeweb", "specifications");
    }

    public function validate_privileges_in_missingimages() {
        return $this->checkPrivilege("backofficeweb", "missingimages");
    }

    public function validate_privileges_in_register_user() {
        return $this->checkPrivilege("gestorintegral", "register");
    }
}

?>
