<?php
include "conexion.php";
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$correo=$_POST['email'];
$clave=$_POST['clave'];
$incriptado= password_hash($clave, algo: PASSWORD_DEFAULT);
$sql="SELECT * FROM administradores WHERE correo='$correo'";
$result=$conexion->query($sql);
if ($result->num_rows < 1) {
    $sql="INSERT INTO `administradores`(`nombre`, `apellido`,`clave`,`correo`) VALUES 
   ('$nombre','$apellido','$incriptado','$correo')";
   $result=$conexion->query($sql);
   header("location: adm.php");
}else{
    echo"Ya hay un registro con ese correo";
}

?>