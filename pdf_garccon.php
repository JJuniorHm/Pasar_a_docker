<?php
require('libraries/fpdf/fpdfst.php');
require "cfig.php";

include "modules/warranty/classes/pdfdetails.php";

class PDF extends FPDF
{
function Header()
{
    global $title;
}

function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
{
    $font_angle+=90+$txt_angle;
    $txt_angle*=M_PI/180;
    $font_angle*=M_PI/180;

    $txt_dx=cos($txt_angle);
    $txt_dy=sin($txt_angle);
    $font_dx=cos($font_angle);
    $font_dy=sin($font_angle);

    $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}

function Footer()
{
    // Posición a 1,5 cm del final
    $this->SetY(-15);
    // Arial itálica 8
    $this->SetFont('Arial','I',8);
    // Color del texto en gris
    $this->SetTextColor(128);
    // Número de página
    $this->Cell(0,10,'',0,0,'C');
}

function ChapterTitle($num, $label)
{
    // Arial 12
    $this->SetFont('Arial','',12);
    // Color de fondo
    $this->SetFillColor(200,220,255);
    // Título
    //$this->Cell(0,6,"Capítulo $num : $label",1,1,'L',true);
    // Salto de línea

}

function Body()
{

    $user = new user();
    $pdfdetails = new pdfdetails();
    $status = '';
    if(!empty($_SESSION['ucoduser'])){
      $coduser = $_SESSION['ucoduser'];
    }
    if($user->getSession()===FALSE){
      header("location:".$base_url ."lgn.php");
    }
    if(isset($_GET['q'])){
      $user->logout();
      header("location:".$base_url ."lgn.php");
    }

    $user->setCodUser($coduser);
    $userinfo = $user->getUserInfo();

    $cgicodin = NULL;
    $cgishop = NULL;

    $vushop = NULL;
    $vunumgui = NULL;
    $vucliente = NULL;
    $vuclientedni = NULL;
    $vudireccion = NULL;
    $vutelefonos = NULL;
    $vushop = NULL;
    $vunumgui = NULL;
    $vuequipo = NULL;
    $vumarca = NULL;
    $vumodelo = NULL;
    $vunumser = NULL;
    $vuaccesorios = NULL;
    $vuestequ = NULL;
    $vucomprobante = NULL;
    $vuprorepcli = NULL;
    $vudiagnostico = NULL;
    $vufecing = NULL;
    $vuhoring = NULL;
    $vufecent = NULL;
    $vuhorent = NULL;
    $vumoncob = NULL;
    $vucodin = NULL;
    $vuestadogi = NULL;
    $vufecentcli = NULL;
    $vutecnico = NULL;
    $vudircaja = NULL;
    $vuprodec = NULL;
    $vuopeequ = NULL;

    if(isset($_GET['wgn']))
    {
      $pdfdetails->SetWGuideNumber($_GET['wgn']);
      $PDFDetails = $pdfdetails->GetPDFDetails();
      if ($PDFDetails)
      {
        $cgicodin = $PDFDetails['wguidenumber'];
        $vucliente = $PDFDetails['crazon'];
        $vuclientedni = $PDFDetails['ccodcli'];
        $vudireccion = $PDFDetails['cdireccion'];
        $vutelefonos = $PDFDetails['ctelefono1']; //. " / " .$PDFDetails['stcc_telefono2'];
        $vushop = $PDFDetails['wendpoint'];
        $vunumgui = $PDFDetails['wguidenumber'];
        $vuequipo = $PDFDetails['categoria'];
        $vumarca = $PDFDetails['marca'];
        $vumodelo = $PDFDetails['descripcion'];
        $vunumser = $PDFDetails['serialnumber'];
        $vuaccesorios = $PDFDetails['waccessories'];
        $vuestequ = $PDFDetails['wequipmentstatus'];
        $vucomprobante = $PDFDetails['wvoucher'];
        $vuprorepcli = $PDFDetails['wprpc'];
        $vudiagnostico = $PDFDetails['wdiagnostic'];
        $vufecing = new DateTime($PDFDetails['wentrydate']);
        $vuhoring = new DateTime($PDFDetails['wentrydate']);
        $vufecent = new DateTime($PDFDetails['wsupplierresolutiondate']);
        $vuhoring = "";
        $vumoncob = $PDFDetails['wpriceproduct'];
        $vucodin = $PDFDetails['wentrycode'];
        $vuestadogi = $PDFDetails['wstage'];
        $vufecentcli = "";
        $vutecnico =  $PDFDetails['urazon'];
        $vuprodec = $PDFDetails['wproblemsdetected'];
        $vuobsfin = $PDFDetails['wconcludingremarks'];
        $vuopeequ = $PDFDetails['wequipmentoperation'];

        // $vutelefono2 = ;
        // $vudireccion = $GIInfo['stcc_direccion'];
        // $vuemail = $GIInfo['stcc_email'];
      }
      else
      {
        header("location:index.php");
      }
    }
    else
    {
      header("location:index.php");
    }

    $estadogi = null;
    $estadofecha = null;
    $stdoetgagr = null;

    if($vuestadogi == 'GESTIÓN DE INTERNAMIENTO') {
        $estadogi = 'RECEPCIÓN';
        $estadofecha = "FECHA: ".$vufecing->format('Y-m-d')." "."HORA: ".$vufecing->format('H:i');
        $tipointerna = "R";
    }
    elseif ($vuestadogi == 'GESTIÓN DE SALIDA') {
        $stdoetgagr = 'ENTREGADO';
        $estadogi = 'SALIDA';
        $estadofecha = "FECHA: ".$vufecing->format('Y-m-d')." "."HORA: ".$vufecing->format('H:i');
        $tipointerna = "E";
    }
    else{
        $stdoetgagr = '';
        $estadogi = 'RECEPCIÓN';
        $estadofecha = "FECHA: ".$vufecing->format('Y-m-d')." "."HORA: ".$vufecing->format('H:i');
        $tipointerna = "R";
    }

    $this->Image('imges/lgos/bgcomswhite.png',10,6,70);
    $this->Image('imges/lgos/favicon2.png',109,11,5);
    $this->SetTextColor(0, 44, 109);
    $this->SetFont('Arial','B',8);
    $this->Cell(83,3,"",0,0,'C');
    $this->Cell(50,3,utf8_decode($vudircaja),0,0,'R');

    // Arial bold 15
    $this->SetFont('Arial','B',11);
    $this->SetX(145);
    // Colores de los bordes, fondo y texto
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(0, 44, 109);
    $this->SetTextColor(240, 255, 240);
    // Ancho del borde (1 mm)
    // $this->SetLineWidth(0);
    $this->Cell(55,6,utf8_decode("GUÍA DE ".$estadogi),1,1,'C',true);

    $this->SetFont('Arial','B',15);
    $this->SetDrawColor(0, 44, 109);
    $this->SetTextColor(0, 0, 0);
    $this->SetX(145);
    $this->Cell(55,7,utf8_decode($vushop."-".str_pad($vunumgui, 6, "0", STR_PAD_LEFT)."-".$tipointerna),1,1,'C');

    $this->SetY(13);
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(0, 44, 109);
    $this->Cell(83,3,"",0,0,'C');
    $this->Cell(50,3,utf8_decode("Teléfono: 978007715"),0,1,'R');
    $this->Cell(83,3,"",0,0,'C');
    $this->Cell(50,1,utf8_decode(""),0,1,'R');
    $this->Cell(83,3,"",0,0,'C');
    $this->Cell(50,3,utf8_decode("comsitec.tech"),0,1,'R');
    $this->Cell(50,2,utf8_decode(""),0,1,'R');
    // Separación de 3 puntos abajo
    $this->Ln(2);

    $this->SetFont('Arial','B',7);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(21,4,"CLIENTE:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(84,4,utf8_decode(substr($vucliente, 0, 40)) ,1,0,'C');

    $this->SetTextColor(255, 255, 255);
    $this->Cell(12,4,"DNI:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(25,4,$vuclientedni,1,0,'C');

    //$this->SetTextColor(255, 255, 255);
    //$this->Cell(26,4,utf8_decode("CÓDIGO GI:"),1,0,'L',true);
    //$this->SetTextColor(0, 0, 0);
    //$this->Cell(22,4,"",0,1,'C'); //$vucodin
    $this->SetTextColor(255, 255, 255);
    $this->Cell(18,4,"TEL/CEL:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(30,4,$vutelefonos,1,1,'C');


    $this->SetTextColor(255, 255, 255);
    $this->Cell(28,4,utf8_decode("DIRECCIÓN:"),1,0,'L', true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(162,4,utf8_decode($vudireccion),1,1,'C');

    $this->Ln(1);

    $this->SetTextColor(255, 255, 255);
    $this->Cell(15,4,"EQUIPO:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(100,4,substr($vumarca." - ".$vumodelo, 0, 60) ,1,0,'C');

    $this->SetTextColor(255, 255, 255);
    $this->Cell(12,4,"SERIE:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(63,4,$vunumser,1,1,'C');

    $this->SetTextColor(255, 255, 255);
    $this->Cell(25,4,"ACCESORIOS:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(165,4,utf8_decode($vuaccesorios),1,0,'C');

    $this->Ln(1);

    //Aqui empieza estado de equipo
    $this->SetY(41);
    $this->SetX(10);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(42,4,"OBSERVACIONES DEL EQUIPO:",1,0,'L',true);
    $this->SetTextColor(0, 0, 0);

    $this->SetY(41);
    $this->SetX(52);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(148,4,utf8_decode($vuestequ),1,1,'C',true);
 
    //Aqui termina estado de equipo

    // AQui empieza
    $this->SetY(46);
    $this->SetX(10);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(63,4,"PROBLEMA REPORTADO POR EL CLIENTE:",1,1,'L',true); // Título del cuadro

    $this->SetY(51);
    $this->SetX(11);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0, 0, 0);
    $this->MultiCell(61,4,utf8_decode($vuprorepcli),0,1,'J',true); // contenido del cuadro

    $this->SetY(46);
    $this->SetX(10);
    $this->Cell(63,55,"",1,1,'L',false); //Caja vacia
    //Aqui termina

    // AQui empieza
    $this->SetY(46);
    $this->SetX(74);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(63,4,utf8_decode("PROBLEMAS DETECTADOS:"),1,1,'L',true); // Título del cuadro

    $this->SetY(51);
    $this->SetX(75);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0, 0, 0);
    $this->MultiCell(61,4,utf8_decode( str_replace(",", "
", $vuprodec)),0,1,'J',true); // contenido del cuadro

    $this->SetY(46);
    $this->SetX(74);
    $this->Cell(63,55,"",1,1,'L',false);  //Caja vacia
    // AQui termina

    // Aqui empieza bloque lista de problemas
    $this->SetY(46);
    $this->SetX(138);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(62,4,"TRABAJO A REALIZAR:",1,1,'L',true);

    $this->SetY(51);
    $this->SetX(139);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0, 0, 0);
    $this->MultiCell(60,4,utf8_decode($vudiagnostico),0,1,'J',true);

    $this->SetY(46);
    $this->SetX(138);
    $this->Cell(62,55,"",1,1,'L',false);
// Aqui termina bloque lista de problemas

    // Aqui empieza bloque lista de problemas
    $this->SetY(102);
    $this->SetX(10);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(101,4,"OBSERVACIONES FINALES:",1,1,'L',true);

    $this->SetY(107);
    $this->SetX(11);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0, 0, 0);
    $this->MultiCell(99,4,utf8_decode( str_replace(",", " ", $vuobsfin)),0,1,'J',true);

    $this->SetY(102);
    $this->SetX(10);
    $this->Cell(101,27,"",1,1,'L',false);
// Aqui termina bloque lista de problemas

    $this->SetTextColor(147, 0, 0);
    $this->SetFont('Arial','B',35);
    $this->TextWithRotation(80,99,$stdoetgagr,45,-0,'C');
    $this->SetFont('Arial','B',22);
    $this->TextWithRotation(93,99,$stdoetgagr,45,-0,'L');

    //Aqui termina

    $this->SetY(102);
    $this->SetX(112);
    $this->SetFont('Arial','B',7);
    $this->SetDrawColor(0, 44, 109);
    $this->SetFillColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(44,4,"COMPROBANTE:",1,0,'L',true);

    $this->SetY(106);
    $this->SetX(112);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(44,4,$vucomprobante,1,0,'C');

    // $this->SetY(102);
    // $this->SetX(157);
    // $this->SetFont('Arial','B',7);
    // $this->SetDrawColor(0, 44, 109);
    // $this->SetFillColor(0, 44, 109);
    // $this->SetTextColor(255, 255, 255);
    // $this->Cell(43,4,"MONTO POR COBRAR:",1,0,'L',true);

    // $this->SetY(106);
    // $this->SetX(157);
    // $this->SetTextColor(0, 0, 0);
    // $this->Cell(43,4,"S/"." ".$vumoncob,1,1,'C');

    //CONFORMIDAD DE INTERNAMIENTO
    $this->SetY(111);
    $this->SetX(112);
    $this->SetFont('Arial','B',7);
    $this->SetDrawColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(44,4,utf8_decode('CONFORMIDAD DE '.$estadogi.':'),1,1,'L',true);

    $this->SetY(115);
    $this->SetX(112);
    $this->Cell(44,10,"",1,1,'C'); //Firma de INTERNAMIENTO
    $this->SetFont('Arial','B',7);
    $this->SetDrawColor(0, 44, 109);
    $this->SetTextColor(0, 0, 0);

    $this->SetY(125);
    $this->SetX(112);
    $this->Cell(44,4,$estadofecha,1,0,'C');
    //CONFORMIDAD DE INTERNAMIENTO

    //CONFORMIDAD DE RECOJO
    //$this->SetY(106);
    //$this->SetX(81);
    //$this->SetFont('Arial','B',9);
    //$this->SetDrawColor(0, 44, 109);
    //$this->SetTextColor(255, 255, 255);
    //$this->Cell(61,4,"CONFORMIDAD DE RECOJO",1,1,'C',true);
    //$this->SetX(81);
    //$this->Cell(61,15,"",1,1,'C'); //Firma de INTERNAMIENTO
    //$this->SetX(81);
    //$this->SetFont('Arial','B',10);
    //$this->SetDrawColor(0, 44, 109);
    //$this->SetTextColor(0, 0, 0);
    //$this->Cell(61,4,"FECHA: ".$vufecent->format('Y-m-d')." "."HORA: ".$vufecent->format('H:i'),1,0,'C');
    //CONFORMIDAD DE RECOJO

    //Sugerencias
    $this->SetY(111);
    $this->SetX(157);
    $this->SetFont('Arial','B',7);
    $this->SetDrawColor(0, 44, 109);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(43,4,utf8_decode("TÉCNICO"),1,1,'L',true);

    $this->SetY(115);
    $this->SetX(157);
    $this->SetFont('Arial','B',10);
    $this->SetDrawColor(0, 44, 109);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(43,10," ",1,1,'C');

    $this->SetY(125);
    $this->SetX(157);
    $this->SetFont('Arial','B',7);
    $this->SetDrawColor(0, 44, 109);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(43,4,$vutecnico,1,0,'C');

    //Sugerencias

    $this->SetY(115);
    $this->SetX(151);

    $this->Cell(2,4,"",0,0,'C');

    $this->Ln(15);
    $this->SetFont('Arial','',7);
    $this->SetTextColor(0, 44, 109);
    $this->Cell(12,3,"NOTA: ",0,0,'L');
    $this->MultiCell(0,3,utf8_decode("-UNA VEZ ATENTIDO Y COMUNICADO, USTED TIENE 5 DÍAS HÁBILES COMO MÁXIMO PARA REALIZAR EL RECOJO DE SU EQUIPO. PASADO ESTE TIEMPO, SE HARÁ EL COBRO POR ALMACENAJE."),0,'L');
    $this->Cell(12,3," ",0,0,'L');
    $this->MultiCell(0,3,utf8_decode("-LA EMPRESA NO SE RESPONSABILIZARÁ POR PRODUCTOS EN ABANDONO POR MÁS DE DOS MESES."),0,'L');
    $this->SetFont('Arial','I',7);
    $this->Cell(12,3," ",0,0,'L');
    $this->MultiCell(0,3,utf8_decode("PARA CUALQUIER CONSULTA COMUNÍQUESE CON NOSOTROS INDICANDO SU NÚMERO DE INTERNAMIENTO."),0,'L');
    $this->Ln(3);
    $this->SetFont('Arial','B',10);
    // $this->MultiCell(44,6,utf8_decode("¿Que tan satisfecho esta con nuestro servicio?."),1,'C');

    // $this->SetY(200); /* Inicio */
    // $this->SetDrawColor(0, 44, 109);
    // $this->SetFont('Arial','B',12);
    // $this->Cell(40,10,'Columna1',1,0,'C');
    // $this->MultiCell(40,10,'palabras y mas palabras',1,'C');
    // $this->SetY(210); /* Set 20 Eje Y */
    // $this->Cell(40,10,'Columna3',1,0,'C');

}

function PrintChapter($num, $title, $file)
{
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->Body();
}
}

$pdf = new PDF();
$title = utf8_decode('GUÍA COMSITEC');
$pdf->SetTitle($title);
//$pdf->SetAuthor('Dennys Mejia');
$pdf->PrintChapter(1,'Texto','Texto');
$pdf->Output();

?>