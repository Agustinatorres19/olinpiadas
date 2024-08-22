<?php
include "conexion.php";

$id=$_GET['id'];

$sql="delete from productos WHERE id_productos=$id";
$result=$conexion->query($sql);
header("location: productos1.php");
?>