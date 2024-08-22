<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $gmail = $_POST['gmail'];
   
    $clave = password_hash($_POST['clave'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO clientes (nombre, apellido, gmail, clave) VALUES ('$nombre', '$apellido', '$gmail', '$clave')";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
