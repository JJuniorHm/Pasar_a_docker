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

class indicator
{

    protected $db;
    private $_coduser;
    private $_userara;
    private $_datayear;
    private $_datamonth;
    private $year;
    private $month;
    private $day;

    public function SetYear($year) { $this->year = $this->db->real_escape_string($year); }
    public function SetMonth($month) { $this->month = $this->db->real_escape_string($month); }
    public function SetDay($day) { $this->day = $this->db->real_escape_string($day); }

    public function setCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }
    public function setUserAra($userara) { $this->_userara = $this->db->real_escape_string($userara); }
    public function setDataYear($datayear) { $this->_datayear = $this->db->real_escape_string($datayear); }
    public function setDataMonth($datamonth) { $this->_datamonth = $this->db->real_escape_string($datamonth); }

    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function GetIndicator()
    {
        $query = 'SELECT COUNT(twi.wguidenumber) as countguidenumber, DAY(twi.wentrydate) as day, SUM(tw.wpriceproduct) AS wpriceproduct
        FROM tb_warranty_indicator twi
        JOIN tb_warranty tw 
        ON twi.wguidenumber = tw.wguidenumber
        WHERE YEAR(twi.wentrydate) = "'.$this->year.'" AND MONTH(twi.wentrydate) = "'.$this->month.'"
        GROUP BY twi.wentrydate';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }
    public function GetIndicatorYearly()
    {
        $query = 'SELECT COUNT(twi.wguidenumber) AS countguidenumber, MONTH(twi.wentrydate) AS month, DAY(twi.wentrydate) AS day, SUM(tw.wpriceproduct) AS wpriceproduct
        FROM tb_warranty_indicator twi
        JOIN tb_warranty tw 
        ON twi.wguidenumber = tw.wguidenumber
        WHERE YEAR(twi.wentrydate) = "'.$this->year.'" AND twi.wentrydate IN ( SELECT MAX(wentrydate) FROM tb_warranty_indicator GROUP BY YEAR(wentrydate), MONTH(wentrydate) )
        GROUP BY DAY(twi.wentrydate), MONTH(twi.wentrydate)
        ORDER BY MONTH(twi.wentrydate), DAY(twi.wentrydate)';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }    

    public function GetIndicatorDetailsYear()
    {
        $query = 'SELECT DISTINCT
                w.wguidenumber, tbc.ccodcli, tbc.crazon, tbc.ctelefono1, tbc.ctelefono2, w.descripcion, w.wpriceproduct, w.wstage, w.wstate
                FROM tb_warranty w
                JOIN tb_clientes tbc
                ON w.ccodcli = tbc.ccodcli
                JOIN tb_warranty_indicator wi
                ON w.wguidenumber = wi.wguidenumber
                WHERE YEAR(wi.wentrydate) = "'.$this->year.'" ORDER BY wguidenumber desc';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function GetIndicatorDetailsMonth()
    {
        $query = 'SELECT DISTINCT
                w.wguidenumber, tbc.ccodcli, tbc.crazon, tbc.ctelefono1, tbc.ctelefono2, w.descripcion, w.wpriceproduct, w.wstage, w.wstate
                FROM tb_warranty w
                JOIN tb_clientes tbc
                ON w.ccodcli = tbc.ccodcli
                JOIN tb_warranty_indicator wi
                ON w.wguidenumber = wi.wguidenumber
                WHERE YEAR(wi.wentrydate) = "'.$this->year.'"
                AND MONTH(wi.wentrydate) = "'.$this->month.'" ORDER BY wguidenumber desc';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function GetIndicatorDetailsDay()
    {
        $query = 'SELECT DISTINCT
                w.wguidenumber, tbc.ccodcli, tbc.crazon, tbc.ctelefono1, tbc.ctelefono2, w.descripcion, w.wpriceproduct, w.wstage, w.wstate
                FROM tb_warranty w 
                JOIN tb_clientes tbc
                ON w.ccodcli = tbc.ccodcli
                JOIN tb_warranty_indicator wi
                ON w.wguidenumber = wi.wguidenumber
                WHERE YEAR(wi.wentrydate) = "'.$this->year.'"
                AND MONTH(wi.wentrydate) = "'.$this->month.'"
                AND DAY(wi.wentrydate) = "'.$this->day.'" ORDER BY wguidenumber desc';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function GetIDCOUNTwgnSUMwppMonth()
    {
        $query = 'SELECT COUNT(wguidenumber) as countwgn, SUM(wpriceproduct) AS sumwpp FROM ( SELECT DISTINCT w.wguidenumber, w.wpriceproduct FROM tb_warranty w JOIN tb_warranty_indicator wi ON w.wguidenumber = wi.wguidenumber WHERE YEAR(wi.wentrydate) = "'.$this->year.'" AND MONTH(wi.wentrydate) = "'.$this->month.'" ) AS distinct_prices;';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnSUMwppYear()
    {
        $query = 'SELECT COUNT(wguidenumber) as countwgn ,SUM(wpriceproduct) as sumwpp FROM tb_warranty WHERE
                YEAR(wentrydate) = "'.$this->year.'";';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnSUMwppMonth()
    {
        $query = 'SELECT COUNT(wguidenumber) as countwgn, SUM(wpriceproduct) as sumwpp FROM tb_warranty WHERE
                YEAR(wentrydate) = "'.$this->year.'" AND MONTH(wentrydate) = "'.$this->month.'";';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnExitYM()
    {
        $query = 'SELECT COUNT(wguidenumber) as countwgnexit, SUM(wpriceproduct) as sumwppexit FROM tb_warranty WHERE (YEAR(wexitdate) = "'.$this->year.'" AND MONTH(wexitdate) = "'.$this->month.'") AND (wstage = "GESTIÓN DE SALIDA" AND wstate = "PRODUCTO ENTREGADO");';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnExitY()
    {
        $query = 'SELECT COUNT(wguidenumber) as countwgnexit, SUM(wpriceproduct) as sumwppexit FROM tb_warranty WHERE (YEAR(wexitdate) = "'.$this->year.'") AND (wstage = "GESTIÓN DE SALIDA" AND wstate = "PRODUCTO ENTREGADO");';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnPendingYMD()
    {
        $query = 'SELECT COUNT(twi.wguidenumber) AS countguidenumber, DAY(twi.wentrydate) AS day, SUM(tw.wpriceproduct) AS wpriceproduct FROM tb_warranty_indicator twi JOIN tb_warranty tw ON twi.wguidenumber = tw.wguidenumber WHERE YEAR(twi.wentrydate) = "'.$this->year.'" AND MONTH(twi.wentrydate) = "'.$this->month.'" AND DAY(twi.wentrydate) = "'.$this->day.'" AND twi.wentrydate = (SELECT MAX(twi_sub.wentrydate)FROM tb_warranty_indicator twi_sub WHERE YEAR(twi_sub.wentrydate) = "'.$this->year.'" AND MONTH(twi_sub.wentrydate) = "'.$this->month.'" AND DAY(twi_sub.wentrydate) = "'.$this->day.'") GROUP BY twi.wentrydate;';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnPendingYM()
    {
        $query = 'SELECT COUNT(twi.wguidenumber) AS countwgnpending, SUM(tw.wpriceproduct) AS sumwpppending FROM tb_warranty_indicator twi JOIN tb_warranty tw ON twi.wguidenumber = tw.wguidenumber WHERE YEAR(twi.wentrydate) = "'.$this->year.'" AND MONTH(twi.wentrydate) = "'.$this->month.'" AND twi.wentrydate = (SELECT MAX(twi_sub.wentrydate)FROM tb_warranty_indicator twi_sub WHERE YEAR(twi_sub.wentrydate) = "'.$this->year.'" AND MONTH(twi_sub.wentrydate) = "'.$this->month.'") GROUP BY twi.wentrydate;';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetCOUNTwgnPendingY()
    {
        $query = 'SELECT COUNT(twi.wguidenumber) AS countwgnpending, SUM(tw.wpriceproduct) AS sumwpppending FROM tb_warranty_indicator twi JOIN tb_warranty tw ON twi.wguidenumber = tw.wguidenumber WHERE YEAR(twi.wentrydate) = "'.$this->year.'" AND twi.wentrydate = (SELECT MAX(twi_sub.wentrydate)FROM tb_warranty_indicator twi_sub WHERE YEAR(twi_sub.wentrydate) = "'.$this->year.'") GROUP BY twi.wentrydate;';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetInfoEfcecy()
    {
        $query = '
                SELECT et.efcecy FROM tb_efcecy_task as et
                INNER JOIN tb_users as user
                ON et.ucoduser = user.ucoduser
                WHERE user.ucoduser = "'.$this->_coduser.'"';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    public function GetInfoAreaEfcecy()
    {
        $query = ' SELECT et.ucoduser, us.unombre1, us.upaterno, us.area, et.efcecy FROM tb_efcecy_task as et INNER JOIN tb_users as us ON et.ucoduser = us.ucoduser WHERE us.area = "'.$this->_userara.'" AND MONTH(et.dtergter) = MONTH(CURRENT_DATE()) AND YEAR(et.dtergter) = YEAR(CURRENT_DATE())';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function get_ListResponsible()
    {
        $query = 'SELECT DISTINCT tbgt.rpsbleid ,tbu.urazon FROM tb_users as tbu INNER JOIN tb_gtor_tras as tbgt ON tbu.ucoduser = tbgt.rpsbleid WHERE tbgt.cadorid = "'.$this->_coduser.'"';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function get_ListYear()
    {
        $query = 'SELECT DISTINCT YEAR(tbiet.dtergter) AS dtergter FROM tb_idctorefcecytask as tbiet JOIN tb_gtor_tras as tbgt ON tbiet.ucoduser = tbgt.rpsbleid WHERE tbgt.cadorid = "'.$this->_coduser.'" ORDER BY YEAR(tbiet.dtergter) DESC';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function get_ListMonth()
    {
        $query = 'SELECT DISTINCT MONTH(dtergter) AS dtergter FROM tb_idctorefcecytask WHERE YEAR(dtergter) = YEAR(CURRENT_DATE())';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function get_SelectYearListMonth()
    {
        $query = 'SELECT DISTINCT MONTH(tbiet.dtergter) AS months FROM tb_idctorefcecytask as tbiet JOIN tb_gtor_tras as tbgt ON tbiet.ucoduser = tbgt.rpsbleid WHERE tbgt.cadorid = "'.$this->_coduser.'" AND YEAR(tbiet.dtergter) = '.$this->_datayear.' ORDER BY YEAR(tbiet.dtergter) DESC';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }

    public function get_SelectMonthListResponsible()
    {
        $query = 'SELECT DISTINCT tbu.ucoduser, tbu.urazon FROM tb_users AS tbu JOIN tb_gtor_tras as tbgt ON tbu.ucoduser = tbgt.rpsbleid JOIN tb_idctorefcecytask AS tbiet ON tbu.ucoduser = tbiet.ucoduser WHERE tbgt.cadorid = "'.$this->_coduser.'" AND YEAR(tbiet.dtergter) = '.$this->_datayear.' AND MONTH(tbiet.dtergter) = '.$this->_datamonth.'';
        $result = $this->db->query($query) or die($this->db->error);
        return $result;
    }
}

?>
