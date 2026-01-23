<?php

include "class_export.php";
$export = new export();

require '../../libraries/vendor/autoload.php'; // Asegúrate de ajustar la ruta según tu estructura de archivos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

if(isset($_POST['filename'])) {
date_default_timezone_set('America/Lima');
$fechaFormateada = date("d.m.y");

  $filename = $_POST['filename'] .'-'.$fechaFormateada. '.xlsx';

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados
$sheet->setCellValue('A1', 'Técnico');
$sheet->setCellValue('B1', 'Cliente');
$sheet->setCellValue('C1', 'Documento de Identidad');
$sheet->setCellValue('D1', 'Dirección');
$sheet->setCellValue('E1', 'Teléfono 1');
$sheet->setCellValue('F1', 'Teléfono 2');
$sheet->setCellValue('G1', 'Número de Guía');
$sheet->setCellValue('H1', 'Código de Producto');
$sheet->setCellValue('I1', 'Categoría');
$sheet->setCellValue('J1', 'Sub Categoría');
$sheet->setCellValue('K1', 'Marca');
$sheet->setCellValue('L1', 'Descripción');
$sheet->setCellValue('M1', 'Serie');
$sheet->setCellValue('N1', 'Accesorios');
$sheet->setCellValue('O1', 'Estado de Equipo');
$sheet->setCellValue('P1', 'Tipo de Guía');
$sheet->setCellValue('Q1', 'Comprobante');
$sheet->setCellValue('R1', 'Problema Reportado por el Cliente');
$sheet->setCellValue('S1', 'Diagnóstico');
$sheet->setCellValue('T1', 'Fecha Ingreso');
$sheet->setCellValue('U1', 'Fecha Salida');
$sheet->setCellValue('V1', 'Etapa');
$sheet->setCellValue('W1', 'Estado');
$sheet->setCellValue('X1', 'Precio Producto');
$sheet->setCellValue('Y1', 'Problema Detectado');
$sheet->setCellValue('Z1', 'Observaciones Finales');


$result = $export->GetExportXLSX();

if ($result->num_rows > 0) {
    // Agregar datos a la hoja
    $row = 2;
    while ($rowdata = $result->fetch_array(MYSQLI_ASSOC)) {
        $sheet->setCellValue('A' . $row, $rowdata['tecnico']);
        $sheet->setCellValue('B' . $row, $rowdata['cliente']);
        $sheet->setCellValue('C' . $row, $rowdata['ccodcli']);
        $sheet->setCellValue('D' . $row, $rowdata['cdireccion']);
        $sheet->setCellValue('E' . $row, $rowdata['ctelefono1']);
        $sheet->setCellValue('F' . $row, $rowdata['ctelefono2']);
        $sheet->setCellValue('G' . $row, $rowdata['wguidenumber']);
        $sheet->setCellValue('H' . $row, $rowdata['codigo']);
        $sheet->setCellValue('I' . $row, $rowdata['categoria']);
        $sheet->setCellValue('J' . $row, $rowdata['subcategoria']);
        $sheet->setCellValue('K' . $row, $rowdata['marca']);
        $sheet->setCellValue('L' . $row, $rowdata['descripcion']);
        $sheet->setCellValue('M' . $row, $rowdata['serialnumber']);
        $sheet->setCellValue('N' . $row, $rowdata['waccessories']);
        $sheet->setCellValue('O' . $row, $rowdata['wequipmentstatus']);
        $sheet->setCellValue('P' . $row, $rowdata['wguidetype']);
        $sheet->setCellValue('Q' . $row, $rowdata['wvoucher']);
        $sheet->setCellValue('R' . $row, $rowdata['wprpc']);
        $sheet->setCellValue('S' . $row, $rowdata['wdiagnostic']);
        $sheet->setCellValue('T' . $row, $rowdata['wentrydate']);
        $sheet->setCellValue('U' . $row, $rowdata['wexitdate']);
        $sheet->setCellValue('V' . $row, $rowdata['wstage']);
        $sheet->setCellValue('W' . $row, $rowdata['wstate']);
        $sheet->setCellValue('X' . $row, $rowdata['wpriceproduct']);
        $sheet->setCellValue('Y' . $row, $rowdata['wproblemsdetected']);
        $sheet->setCellValue('Z' . $row, $rowdata['wconcludingremarks']);

        $row++;
    }
    $sheet->getStyle('C2:C' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
    $sheet->getStyle('H2:H' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
    $sheet->getStyle('X2:X' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
    //$sheet->getStyle('T2:T' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
    //$sheet->getStyle('U2:U' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
} else {
    echo "0 resultados";
}

// Guardar el libro en un archivo Excel
$writer = new Xlsx($spreadsheet);
$writer->save('../../'.$filename);


echo $filename;

} else {
  echo "Nombre de archivo no especificado.";
}










?>