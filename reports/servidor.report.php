<?php
require('../reports/fpdf.php'); require_once("../models/servidor.model.php");
//PDF
$pdf= new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Text(30,10, 'Reporte');
$pdf->Ln(20);
//Imagen Logo Empresa
//Encabezado Columnas
$texto="";
$pdf-> MultiCell(0,5, iconv('UTF-8','windows-1252',$texto),0,'5');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,"#",1);
$pdf->Cell(50,10,"Nombre",1);
$pdf->Cell(50,10,"Descripcion",1);
$pdf->Cell(30,10,"Precio",1);
$pdf->Cell(30,10,"Stock",1);
$pdf->Cell(30,10,"Categoria",1);

$pdf->Ln();
//Conexion DB
$server="localhost"; $user="interpc"; $password="Codex2017.@1987"; $database="interpc.net@";
$conexion = new mysqli($server,$user,$password,$database);
if($onexion-> connect_errno){
    die("Error" .$conexion->connect_error);
}
//Consulta desde la BD

?>