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
        $keywords = explode(" ", trim($this->_evarcdnabqda));
        $keywords = array_filter($keywords);
        $baseQuery = "
            SELECT 
                tbw.wnumberid,
                tbc.crazon,
                tbu.urazon,
                tbw.guidesource,
                tbw.guidenumbersource,
                tbw.wendpoint,
                tbw.wguidenumber,
                tbw.codigo,
                tbw.categoria,
                tbw.subcategoria,
                tbw.descripcion,
                tbw.marca,
                tbw.serialnumber,
                tbw.waccessories,
                tbw.wequipmentstatus,
                tbw.wvoucher,
                tbw.wprpc,
                tbw.wdiagnostic,
                tbw.wsupplierpurchasedate,
                tbw.wentrydate,
                tbw.wsupplierentrydate,
                tbw.wsupplierstate,
                tbw.wproductlocation,
                tbw.wguidetype,
                tbw.wsupplierresolutiondate,
                tbw.wsupplierresolution,
                tbw.wentrycode,
                tbw.wstage,
                tbw.wstate,
                tbw.wpriceproduct,
                tbw.wequipmentoperation,
                tbw.wproblemsdetected,
                tbw.wconcludingremarks,
                COALESCE(COUNT(wtl.wguidenumber), 0) AS timelines
            FROM tb_warranty tbw
            INNER JOIN tb_clientes tbc ON tbw.ccodcli = tbc.ccodcli
            INNER JOIN tb_users tbu ON tbw.ucoduser = tbu.ucoduser
            LEFT JOIN tb_warranty_timeline wtl ON tbw.wguidenumber = wtl.wguidenumber
        ";
        $params = [];
        $types  = "";
        $whereParts = [];
        foreach ($keywords as $kw) {
            $kw = "%$kw%";
            $whereParts[] = "(
                tbw.wguidenumber LIKE ? OR 
                tbc.crazon LIKE ? OR 
                tbw.descripcion LIKE ? OR 
                tbw.serialnumber LIKE ? OR 
                tbw.marca LIKE ?
            )";
            $types .= "sssss";
            array_push($params, $kw, $kw, $kw, $kw, $kw);
        }
        if (!empty($whereParts)) {
            $baseQuery .= " WHERE " . implode(" AND ", $whereParts);
        }
        $baseQuery .= "
            GROUP BY tbw.wguidenumber
            ORDER BY tbw.wguidenumber DESC
        ";
        $stmt = $this->db->prepare($baseQuery);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}

?>
