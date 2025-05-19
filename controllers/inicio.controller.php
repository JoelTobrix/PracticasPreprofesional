<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
//Conexion database
$conexion= new mysqli("localhost","interpc","Codex2017.@1987","interpc.net@");
if($conexion->connect_error){
     die("Error de conexión: " . $conexion->connect_error);
}
   //Verificar llegada, campos de formulario
   if(isset($_POST['correo'] && isset($_POST['contraseña']))){

    $mail= $_POST['correo'];
    $pass= $_POST['cortraseña'];

    //Ingreso login
    $sql_consultar="SELECT * FROM usuario WHERE  email='$mail' AND password='$pass'";
    $result= $conexion-> query($sql);
       //Verify register
       if($result-> num_rows>0){
        header("Location: ../views/interpc.php");
        exit();
       }else{
        echo "Correo o contraseña incorrectos.";
       }   $stmt->close();
   }else{
    echo "Complete los campos";
   
   }
    $conexion-> close();
?>