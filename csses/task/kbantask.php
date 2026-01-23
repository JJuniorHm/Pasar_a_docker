<?php

class kbantask
{
    protected $db;
    private $_coduser;
    private $_dtnmroid;
    private $_dteqpo;

    public function setCodUser($coduser) { $this->_coduser = $this->db->real_escape_string($coduser); }  
    public function Set_dtnmroid($dtnmroid){ $this->_dtnmroid = $this->db->real_escape_string($dtnmroid) ;}
    public function Set_dteqpo($dteqpo) { $this->_dteqpo = $this->db->real_escape_string($dteqpo) ;}

    public function __construct() {
        // Obtener la instancia única de la conexión
        $this->db = DBConnection::getInstance()->getConnection();
    }

// Pruebas
        public function GetListGrtas()
    {
        $sql = "
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

                gt.nmroid,
                gt.cadorid,
                gt.rpsbleid,
                gt.ttlo,
                gt.dccon,
                gt.fchareg,
                gt.fchalmte,
                gt.etdofchalmte,
                gt.etdo,
                gt.nvel
            FROM tb_gtor_tras AS gt
            INNER JOIN tb_users AS cador ON gt.cadorid = cador.ucoduser
            INNER JOIN tb_users AS rpsble ON gt.rpsbleid = rpsble.ucoduser
            WHERE gt.etdo IN ('En Progreso', 'Pendientes de Revisar')
            AND (gt.cadorid = ? OR gt.rpsbleid = ?)
            GROUP BY gt.nmroid
            ORDER BY gt.nmroid DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $this->_coduser, $this->_coduser);
        $stmt->execute();

        return $stmt->get_result();
    }


}

?>