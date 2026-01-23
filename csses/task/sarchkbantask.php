<?php
include "../../icdes/Sconzton.php";

class user
{
    protected $db;
    private $_coduser;
    private $_userara;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }

    public function setUserAra($userara) { 
        $this->_userara = trim($userara); 
    }

    public function getSession() {
        return !empty($_SESSION['lgingtoritgral']) && $_SESSION['lgingtoritgral'] === TRUE;
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    public function getUserInfo()
    {
        $sql = "
            SELECT ucoduser, udni, urazon, udireccion,
                   utelefono1, upaterno, umaterno,
                   unombre1, unombre2, ucorreo, upassword, area
            FROM tb_users
            WHERE ucoduser = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $this->_coduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}


class sarchkbantask
{
    protected $db;
    private $_coduser;
    private $_evarcdnabqda;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function EvarCdnaBqda($evarcdnabqda) { 
        $this->_evarcdnabqda = trim($evarcdnabqda); 
    }

    public function setCodUser($coduser) { 
        $this->_coduser = trim($coduser); 
    }


    public function GetListGrtas()
    {
        $keywords = array_values(array_filter(explode(" ", $this->_evarcdnabqda)));

        $baseSql = "
            SELECT 
                cador.ucoduser AS cucoduser,
                cador.urazon   AS curazon,
                cador.upaterno AS cupaterno,
                cador.umaterno AS cumaterno,
                cador.unombre1 AS cunombre1,
                
                rpsble.ucoduser AS rucoduser,
                rpsble.urazon   AS rurazon,
                rpsble.upaterno AS rupaterno,
                rpsble.umaterno AS rumaterno,
                rpsble.unombre1 AS runombre1,

                gt.nmroid, gt.cadorid, gt.rpsbleid, gt.ttlo,
                gt.dccon, gt.fchareg, gt.fchalmte,
                gt.etdofchalmte, gt.etdo, gt.nvel
            FROM tb_gtor_tras AS gt
            INNER JOIN tb_users AS cador ON gt.cadorid = cador.ucoduser
            INNER JOIN tb_users AS rpsble ON gt.rpsbleid = rpsble.ucoduser
            WHERE (gt.cadorid = ? OR gt.rpsbleid = ?)
        ";

        $params = [];
        $types  = "ss";          // dos strings por defecto
        $params[] = $this->_coduser;
        $params[] = $this->_coduser;

        if (!empty($keywords)) {

            foreach ($keywords as $kw) {
                $baseSql .= "
                    AND (
                        rpsble.urazon LIKE ?
                        OR gt.dccon   LIKE ?
                        OR gt.nmroid  LIKE ?
                    )
                ";

                $like = "%{$kw}%";
                $types .= "sss";
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
            }
        }

        $baseSql .= "
            GROUP BY gt.nmroid
            ORDER BY gt.nmroid DESC
        ";

        $stmt = $this->db->prepare($baseSql);

        // bind dinámico
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
