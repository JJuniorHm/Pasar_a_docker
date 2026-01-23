<?php

$ruta_original = "includes/Sconzton.php";

if (file_exists($ruta_original)) {
    include $ruta_original;
} else {
    $ruta_alternativa = "../../../includes/Sconzton.php";
    if (file_exists($ruta_alternativa)) {
        include $ruta_alternativa;
    } else {
        echo "El archivo no se encontró en ninguna de las rutas especificadas.";
    }
}

class Products
{
    protected $db;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function Get_CategoryList()
    {
        $sql = "
            SELECT DISTINCT categoria AS categorias
            FROM tb_prod
            ORDER BY categoria ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }
}

?>
