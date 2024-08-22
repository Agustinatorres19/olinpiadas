<?php
include "conexion.php";

$id=$_GET['id'];
$respuesta="enviando";
$sql2="UPDATE peticion_compras SET proceso='$respuesta' WHERE id_peticiones_compras=$id";
    $result2=$conexion->query($sql2);
    header("location: entregar.php");
        session_start();
        $_SESSION['msj'] = "Solicitud aceptada con exito";
?>