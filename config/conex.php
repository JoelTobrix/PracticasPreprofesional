<?php
$server="localhost";
$user="interpc";
$password="Codex2017.@1987";
$database="interpc.net@";

  //Estable connection
  $conn= new mysqli($server,$user,$password,$database);
  if($conn->connect_errno){
    die(" error " .$conn-> connect_errno);
  }else{
    
  } //close connection
  
?>