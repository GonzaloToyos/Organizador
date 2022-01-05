<?php
session_start();
require("db.php");
require("vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$resultado_tareas = mysqli_query($conn, $_SESSION['consulta_excel']);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle($_SESSION['usuario']);

$hojaActiva->setCellValue('A1', 'Título');
$hojaActiva->setCellValue('B1', 'Descripción');
$hojaActiva->setCellValue('C1', 'Fecha');

$hojaActiva->getColumnDimension('A')->setWidth(120, 'pt');
$hojaActiva->getColumnDimension('B')->setWidth(120, 'pt');
$hojaActiva->getColumnDimension('C')->setWidth(120, 'pt');

$fila = 2;

while ($row = mysqli_fetch_array($resultado_tareas)) {
    $hojaActiva->setCellValue('A' . $fila, $row['title']);
    $hojaActiva->setCellValue('B' . $fila, $row['description']);
    $hojaActiva->setCellValue('C' . $fila, $row['reg_date']);
    $fila++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');

exit;