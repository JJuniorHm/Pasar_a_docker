<?php
include "../../icdes/Sconzton.php";

class user
{
    protected $db;
    private $ucoduser;
    private $_userara;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setUCodUser($ucoduser) { 
        $this->ucoduser = trim($ucoduser);
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
        $stmt->bind_param("s", $this->ucoduser);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}



class insert_w
{
    protected $db;

    private $ccodcli;
    private $ucoduser;
    private $wvoucher;
    private $wpriceproduct;
    private $codigo;
    private $descripcion;
    private $categoria;
    private $subcategoria;
    private $marca;
    private $waccessories;
    private $serialnumber;
    private $wprpc;
    private $wequipmentstatus;
    private $wdiagnostic;
    private $wproblemsdetected;
    private $wconcludingremarks;
    private $dtfchalmte;

    public function __construct() {
        $this->db = DBConnection::getInstance()->getConnection();
    }

    public function setUCodUser($v){ $this->ucoduser = trim($v); }
    public function setCCodcli($v){ $this->ccodcli = trim($v); }
    public function setWVaucher($v){ $this->wvoucher = trim($v); }
    public function setWPriceProduct($v){ $this->wpriceproduct = trim($v); }
    public function setCodigo($v){ $this->codigo = trim($v); }
    public function setDescripcion($v){ $this->descripcion = trim($v); }
    public function setCategoria($v){ $this->categoria = trim($v); }
    public function setSubcategoria($v){ $this->subcategoria = trim($v); }
    public function setMarca($v){ $this->marca = trim($v); }
    public function setWAccessories($v){ $this->waccessories = trim($v); }
    public function setSerialNumber($v){ $this->serialnumber = trim($v); }
    public function setWPRPC($v){ $this->wprpc = trim($v); }
    public function setWEquipmentStatus($v){ $this->wequipmentstatus = trim($v); }
    public function setWDiagnostic($v){ $this->wdiagnostic = trim($v); }
    public function setWProblemsDetected($v){ $this->wproblemsdetected = trim($v); }
    public function setWConcludingRemarks($v){ $this->wconcludingremarks = trim($v); }
    public function setDTFchalmte($v){ $this->dtfchalmte = trim($v); }


    public function insert_w()
    {
        // generar código único
        $codigo = $this->generarCodigo(10);

        // obtener correlativo
        $sqlN = "SELECT (MAX(wguidenumber) + 1) AS ngrmasuno FROM tb_warranty";
        $row = $this->db->query($sqlN)->fetch_assoc();
        $ngr = $row['ngrmasuno'] ?? 1;

        $sql = "
            INSERT INTO tb_warranty (
                ccodcli, ucoduser, guidesource, guidenumbersource,
                wendpoint, wguidenumber, wvoucher, wpriceproduct,
                codigo, descripcion, categoria, subcategoria,
                marca, waccessories, serialnumber, wprpc,
                wequipmentstatus, wdiagnostic, wproblemsdetected,
                wconcludingremarks, wentrydate, westimateddate,
                wguidetype, wproductlocation, wentrycode, wstage
            )
            VALUES (
                ?, ?, 'GI001', ?, 
                'GI001', ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?,
                ?, NOW(), ?,
                'Cliente', 'Comsitec', ?, 'GESTIÓN DE INTERNAMIENTO'
            )
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "ssssssssssssssssssssss",
            $this->ccodcli,
            $this->ucoduser,
            $ngr,
            $ngr,
            $this->wvoucher,
            $this->wpriceproduct,
            $this->codigo,
            $this->descripcion,
            $this->categoria,
            $this->subcategoria,
            $this->marca,
            $this->waccessories,
            $this->serialnumber,
            $this->wprpc,
            $this->wequipmentstatus,
            $this->wdiagnostic,
            $this->wproblemsdetected,
            $this->wconcludingremarks,
            $this->dtfchalmte,
            $codigo
        );

        return $stmt->execute();
    }


    private function generarCodigo($longitud)
    {
        do {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code = '';

            for ($i = 0; $i < $longitud; $i++) {
                $code .= $chars[rand(0, strlen($chars) - 1)];
            }

            $sql = "SELECT 1 FROM tb_warranty WHERE wentrycode = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $code);
            $stmt->execute();

            $exists = $stmt->get_result()->num_rows > 0;

        } while ($exists);

        return $code;
    }
}
?>
