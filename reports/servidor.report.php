<?php
require('../reports/fpdf.php'); require_once("../models/servidor.model.php");
//PDF
$pdf= new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Text(30,10, 'Reporte de productos',0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,10, 'Generado el: '.date('d/m/Y'), 0, 1);
$pdf->Cell(0,10, 'Hora:' .date('h:i:s A'), 0, 1);
$pdf->Ln(20);
$pdf->SetFillColor(200,200,200); // Gris claro
$pdf->SetTextColor(0,0,0);       // Texto negro
$pdf->SetFont('Arial','B',10);

//Imagen Logo Empresa
$pdf->Image('../img/logo.png',160,10,30);
//Encabezado Columnas
$texto="";
$pdf-> MultiCell(0,5, iconv('UTF-8','windows-1252',$texto),0,'5');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,"#",1,0,'C',true);
$pdf->Cell(50,10,"Nombre",1,0,'C',true);
$pdf->Cell(50,10,"Descripcion",1,0,'C',true);
$pdf->Cell(30,10,"Precio",1,0,'C',true);
$pdf->Cell(30,10,"Stock",1,0,'C',true);
$pdf->Cell(30,10,"Categoria",1,0,'C',true);

$pdf->Ln();
//Conexion DB
$server="localhost"; $user="interpc"; $password="Codex2017.@1987"; $database="interpc.net@";
$conexion = new mysqli($server,$user,$password,$database);
if($onexion-> connect_errno){
    die("Error" .$conexion->connect_error);
}
//Consulta desde la BD
$query="SELECT `producto_id`,`nombre`,`descripcion`,`precio`,`stock`,`categoria` FROM `producto`";
$resultado= $conexion-> query($query);
$pdf-> SetFont('Arial','',10);
$index=1;
       while($muestra= $resultado->fetch_assoc()){
        $pdf->Cell(10,10, $index,1);
        $pdf->Cell(50,10,$muestra["nombre"],1);
        $pdf->Cell(50,10,$muestra["descripcion"],1);
        $pdf->Cell(30,10,$muestra["precio"],1);
        $pdf->Cell(30,10,$muestra["stock"],1);
        $pdf->Cell(30,10,$muestra["categoria"],1); 
      $pdf->Ln();
      $index ++;  
       }
        //Close connection
        $conexion->close();
        //Generate PDF
        $pdf->Output();
?>