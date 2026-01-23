<?php 
class warranty
{
    protected $db;
    private $_coduser;
    private $_dtnmroid;
    private $_dteqpo;

    public function setCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }  
    public function Set_dtnmroid($dtnmroid){ $this->_dtnmroid = $this->db->real_escape_string($dtnmroid) ;}
    public function Set_dteqpo($dteqpo) { $this->_dteqpo = $this->db->real_escape_string($dteqpo) ;}

    public function setUserAra($userara) { $this->_userara = $this->db->real_escape_string($userara) ;}

    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

// Pruebas
    public function GetList()
    {
        $query = 'SELECT tbw.wnumberid, tbc.crazon, tbu.urazon, tbw.guidesource, tbw.guidenumbersource, tbw.wendpoint, tbw.wguidenumber, tbw.codigo, tbw.categoria, tbw.subcategoria, tbw.descripcion, tbw.marca, tbw.serialnumber, tbw.waccessories, tbw.wequipmentstatus, tbw.wvoucher, tbw.wprpc, tbw.wdiagnostic, tbw.wsupplierpurchasedate, tbw.wentrydate, tbw.wsupplierentrydate, tbw.wsupplierstate, tbw.wproductlocation, tbw.wguidetype, tbw.wsupplierresolutiondate, tbw.wsupplierresolution, tbw.wentrycode, tbw.wstage, tbw.wstate, tbw.wpriceproduct, tbw.wequipmentoperation, tbw.wproblemsdetected, tbw.wconcludingremarks
            FROM tb_warranty as tbw
            INNER JOIN tb_clientes as tbc ON tbw.ccodcli = tbc.ccodcli
            INNER JOIN tb_users as tbu ON tbw.ucoduser = tbu.ucoduser
            WHERE wstate <> "PRODUCTO ENTREGADO"
            GROUP BY tbw.wguidenumber ORDER BY tbw.wguidenumber DESC';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

}

?>