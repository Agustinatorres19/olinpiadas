<?php
include "conexion.php";
$id=$_GET['id'];
$sql="delete from administradores WHERE id_administradores=$id";
$result=$conexion->query($sql);
header("location: adm.php");
?>
