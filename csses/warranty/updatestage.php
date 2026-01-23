<?php
include "../../icdes/Sconzton.php";
class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function SetUCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }
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

class updatestage
{

    protected $db;
    private $ucoduser;
    private $wguidenumber;
    private $wstage;

    public function SetUCodUser($ucoduser) { $this->ucoduser = $this->db->real_escape_string($ucoduser); }
    public function SetWGuideNumber($wguidenumber) { $this->wguidenumber = $this->db->real_escape_string($wguidenumber); }
    public function SetWStage($wstage){ $this->wstage = $this->db->real_escape_string($wstage); }

    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }
    public function UpdateStage()
    {
        $query = 'SELECT tbc.ccodcli, tbw.wguidenumber, tbw.wguidetype, tbw.wstage, tbw.wstate FROM tb_warranty as tbw INNER JOIN tb_clientes as tbc ON tbw.ccodcli = tbc.ccodcli WHERE tbw.wguidenumber = "'.$this->wguidenumber.'" AND tbw.wguidetype = "Cliente"';           
        $result = $this->db->query($query) or die($this->db->error);            
        $count_row = $result->num_rows;
        $item = $result->fetch_assoc();

        if($count_row == 1)
        {
            $istarquery = 'INSERT INTO tb_warranty_timeline SET 
            ucoduser="'.$this->ucoduser.'",
            wguidenumber="'.$item['wguidenumber'].'",
            wguidetipe="'.$item['wguidetype'].'",
            wtl_title="Etapa Cambiada",
            wtl_description="'.$item['wstage'].' -> '.$this->wstage.'",
            wtl_entrydate=CURTIME()';
            $istarresult = $this->db->query($istarquery) or die($this->db->error);

            $query = 'UPDATE tb_warranty SET 
            wstage="'.$this->wstage.'",
            wstate = "" 
            WHERE wguidenumber="'.$this->wguidenumber.'"';
            $result = $this->db->query($query) or die($this->db->error);
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>