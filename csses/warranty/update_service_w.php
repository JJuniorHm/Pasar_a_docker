<?php
include "../../icdes/Sconzton.php";
class user
{
    protected $db;
    private $ucoduser;
    private $_userara;

    public function setCodUser($ucoduser) { $this->ucoduser = $this->db->real_escape_string($ucoduser); }
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
        $query = "SELECT ucoduser,udni,urazon, udireccion, utelefono1, upaterno, umaterno, unombre1, unombre2, ucorreo, upassword, area FROM tb_users WHERE ucoduser = ".$this->ucoduser;
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }
}

class update_service_w
{

    protected $db;
    private $ucoduser;
    private $wguidenumber;
    private $wstate;
    private $waccessories;
    private $wprpc;
    private $wequipmentstatus;
    private $wdiagnostic;
    private $wproblemsdetected;
    private $wconcludingremarks;

    public function SetUCodUser($ucoduser) { $this->ucoduser = $this->db->real_escape_string($ucoduser); }
    public function SetWGuideNumber($wguidenumber) { $this->wguidenumber = $this->db->real_escape_string($wguidenumber); }
    public function SetWState($wstate) { $this->wstate = $this->db->real_escape_string($wstate); }

    public function setWAccessories($waccessories) {$this->waccessories = $this->db->real_escape_string($waccessories);}
    public function setWPRPC($wprpc) {$this->wprpc = $this->db->real_escape_string($wprpc);}
    public function setWEquipmentStatus($wequipmentstatus) {$this->wequipmentstatus = $this->db->real_escape_string($wequipmentstatus);}
    public function setWDiagnostic($wdiagnostic) {$this->wdiagnostic = $this->db->real_escape_string($wdiagnostic);}
    public function setWProblemsDetected($wproblemsdetected) {$this->wproblemsdetected = $this->db->real_escape_string($wproblemsdetected);}
    public function setWConcludingRemarks($wconcludingremarks) {$this->wconcludingremarks = $this->db->real_escape_string($wconcludingremarks);}



    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

// Pruebas
    public function update_service_w()
    {

        $query = 'SELECT tbc.ucoduser, tbw.wguidenumber, tbw.wstate, tbw.wstage, tbw.wguidetype FROM tb_warranty as tbw INNER JOIN tb_users as tbc ON tbw.ucoduser = tbc.ucoduser WHERE wguidenumber = "'.$this->wguidenumber.'"';
        $result = $this->db->query($query) or die($this->db->error);            
        $count_row = $result->num_rows;
        $item = $result->fetch_assoc();

        if($count_row == 1){

            $query = 'UPDATE tb_warranty SET 
            waccessories = "'.$this->waccessories.'",
            wprpc = "'.$this->wprpc.'",
            wequipmentstatus = "'.$this->wequipmentstatus.'",
            wdiagnostic = "'.$this->wdiagnostic.'",
            wproblemsdetected = "'.$this->wproblemsdetected.'",
            wconcludingremarks = "'.$this->wconcludingremarks.'"
            WHERE wguidenumber = '.$this->wguidenumber.'';
            $result = $this->db->query($query) or die($this->db->error);
            return true;
        } else {
            return false;
        }
    }

    //Posiblemente ya no se use al actualizar el servicio de la guía
    public function GetTimeLine()
    {
        $query = 'SELECT * FROM tb_warranty_timeline as tbwtl
                INNER JOIN tb_users as tbu ON tbwtl.ucoduser = tbu.ucoduser
                WHERE wguidenumber="'.$this->wguidenumber.'" ORDER BY wtl_entrydate DESC';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result;
        return $user_data;
    }

}

?>