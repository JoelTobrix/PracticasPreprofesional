<?php
$server="localhost";
$user="interpc";
$password="Codex2017.@1987";
$database="interpc.net@";

  //Estable connection
  $conexion= new mysqli($server,$user,$password,$database);
  if($conexion->connect_errno){
    die(" error " .$conexion-> connect_errno);
  }else{
    echo "Conexion Exitosa ";
  } //close connection
  $conexion-> close();
?>