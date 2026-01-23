<?php 
echo "<pre>";
echo __FILE__;
echo "</pre>";

$ruta_original = "includes/Sconzton.php";

// Verificar si el archivo existe en la ruta original
if (file_exists($ruta_original)) {
    include $ruta_original;
} else {
    // Si no se encuentra en la ruta original, intenta con la ruta alternativa
    $ruta_alternativa = "../../includes/Sconzton.php";
    if (file_exists($ruta_alternativa)) {
        include $ruta_alternativa;
    } else {
        // Si el archivo no se encuentra en ninguna de las rutas, mostrar un mensaje de error
        echo "El archivo no se encontrÃ³ en ninguna de las rutas especificadas.";
    }
}


class orders {
    private $pcodped;

    public function setpcodped($pcodped) { $this->pcodped = $this->db->real_escape_string($pcodped); }
    public function setcodigo($codigo) { $this->codigo = $this->db->real_escape_string($codigo); }
    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }
    public function get_listclientguest() {

        $query = 'SELECT * FROM tb_clientguest WHERE pcodped = ?';
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die('Error de preparación: ' . $this->db->error);
        }
        
        $stmt->bind_param('s', $this->pcodped);
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $fields = [];
        $row = [];  
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);
        $orders = [];
        while ($stmt->fetch()) {
            $orders[] = array_map(function ($val) {
                return $val;
            }, $row);
        }
        return $orders;
    }
    public function get_orders() {
        $query = 'SELECT * FROM tb_pedido ORDER BY pdatecreate desc LIMIT ?';
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die('Error de preparación: ' . $this->db->error);
        }
    
        $limit = 12;
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $fields = [];
        $row = [];  
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);
        $orders = [];
        while ($stmt->fetch()) {
            $orders[] = array_map(function ($val) {
                return $val;
            }, $row);
        }
        return $orders;
    }
    public function get_listproducts() {
        $query = 'SELECT * FROM tb_pedido_lista WHERE pcodped = ?';
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die('Error de preparación: ' . $this->db->error);
        }
        
        $stmt->bind_param('s', $this->pcodped);
        $stmt->execute();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $fields = [];
        $row = [];  
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);
        $orders = [];
        while ($stmt->fetch()) {
            $orders[] = array_map(function ($val) {
                return $val;
            }, $row);
        }
        return $orders;
    }
} 