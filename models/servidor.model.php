<?php
//Conexion DATABASE
$server="localhost";
$user="interpc";
$password="Codex2017.@1987";
$db="interpc.net@";

class Conectividad{
    public function consultar(){
        global $server,$user,$password,$db;
        try{
            $conexion= new mysqli($server,$user,$password,$db);
            if($conexion->connect_errno){
                die("error" .$conexion->connect_error);
            }
            $query="SELECT * FROM `producto`";
            $resultado= $conexion->query($query);
            if($resultado->num_rows>0){
                $datos=[];
                 while($fila=$resultado->fetch_assoc()){
                    $datos[]= $fila;
                 }
                 $conexion-> close(); return $datos;
            }else{
                  $conexion-> close(); return "No hay datos";
            }
        }  catch(Exception $e){
            return " Exception: " .$e-> getMessage();
        }
    }
}
?>