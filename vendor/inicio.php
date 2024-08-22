<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gmail = $_POST['gmail'];
    $clave = $_POST['clave'];

    $sql = "SELECT * FROM clientes WHERE gmail='$gmail'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
        if (password_verify($clave, $row['clave'])) {
            header('Location: momo/index.php');
            exit();
        } else {
            header('Location: inicio.php');
            exit();
        }
    } else {
        header('Location: inicio.php');
        exit();
    }

    mysqli_close($conn);
}
?>
