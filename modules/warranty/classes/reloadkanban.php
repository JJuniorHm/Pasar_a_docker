<?php
include "../../../includes/Sconzton.php";
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

    $result = $stmt->get_result();
    return $result->fetch_array(MYSQLI_ASSOC);
}

}

class reloadkanban
{

    protected $db;
    private $_coduser;
    private $_dtnmroid;
    private $_dteqpo;
    private $_evarcdnabqda;
    public function EvarCdnaBqda($evarcdnabqda) { $this->_evarcdnabqda = $this->db->real_escape_string($evarcdnabqda); }
    public function setCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }  
    public function Set_dtnmroid($dtnmroid){ $this->_dtnmroid = $this->db->real_escape_string($dtnmroid) ;}
    public function Set_dteqpo($dteqpo) { $this->_dteqpo = $this->db->real_escape_string($dteqpo) ;}
    public function setUserAra($userara) { $this->_userara = $this->db->real_escape_string($userara) ;}
        public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

// Pruebas
        public function GetListKanban()
    {
        $search = isset($this->_evarcdnabqda) ? trim($this->_evarcdnabqda) : '';
        if ($search === '') {
            $keywords = [];
        } else {
            $keywords = explode(" ", $search);
            $keywords = array_filter($keywords);
        }

        $sql = "
            SELECT 
                tbw.wnumberid, tbc.crazon, tbu.urazon, tbw.guidesource, tbw.guidenumbersource,
                tbw.wendpoint, tbw.wguidenumber, tbw.codigo, tbw.categoria, tbw.subcategoria,
                tbw.descripcion, tbw.marca, tbw.serialnumber, tbw.waccessories,
                tbw.wequipmentstatus, tbw.wvoucher, tbw.wprpc, tbw.wdiagnostic,
                tbw.wsupplierpurchasedate, tbw.wentrydate, tbw.wsupplierentrydate,
                tbw.wsupplierstate, tbw.wproductlocation, tbw.wguidetype,
                tbw.wsupplierresolutiondate, tbw.wsupplierresolution, tbw.wentrycode,
                tbw.wstage, tbw.wstate, tbw.wpriceproduct, tbw.wequipmentoperation,
                tbw.wproblemsdetected, tbw.wconcludingremarks,
                COALESCE(COUNT(wtl.wguidenumber), 0) AS total_timeline
            FROM tb_warranty AS tbw
            INNER JOIN tb_clientes AS tbc ON tbw.ccodcli = tbc.ccodcli
            INNER JOIN tb_users   AS tbu ON tbw.ucoduser = tbu.ucoduser
            LEFT JOIN tb_warranty_timeline AS wtl 
                ON tbw.wguidenumber = wtl.wguidenumber
            WHERE 1=1
        ";
        $params = [];
        $types  = "";

        // construir filtros dinámicos PERO con parámetros
        foreach ($keywords as $k) {
            $sql .= " AND (
                tbw.wguidenumber LIKE ?
                OR tbc.crazon LIKE ?
                OR tbw.descripcion LIKE ?
                OR tbw.serialnumber LIKE ?
                OR tbw.marca LIKE ?
            )";
            $like = "%$k%";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $types .= "sssss";
        }
        $sql .= "
            GROUP BY tbw.wguidenumber
            ORDER BY tbw.wguidenumber DESC
        ";
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }


}

?>
