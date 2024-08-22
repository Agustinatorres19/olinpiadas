<?php
require "conexion.php";

$correo=$_POST['email'];
$pasword=$_POST['clave'];

// Consulta para obtener la contraseña encriptada del usuario
$sql="select clave, nombre from administradores where correo='$correo'";
$stmt=$conexion->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conexion->error);
}

// Enlazar parámetro y ejecutar la consulta
$stmt->execute();

// Obtener resultados
$result = $stmt->get_result();

// Verificar si se encontró un usuario con el nombre proporcionado
if ($result->num_rows === 1){
    // Obtener la contraseña encriptada del resultado
    $fila = $result->fetch_assoc();
    $contrasena_encriptada = $fila['clave'];
    $nombre = $fila['nombre'];


    // Verificar si la contraseña proporcionada coincide con la contraseña encriptada
    if (password_verify($pasword, $contrasena_encriptada)) {
        header("location: adm.php");
        session_start();
        $_SESSION['msj'] = "bienvenido, $nombre";
    } else {
        header("location: admin.php");
        session_start();
        $_SESSION['msj'] = "la contraseña es incorrecta intenta de nuevo";
    }
} else {
    header("location: admin.php");
    session_start();
    $_SESSION['msj'] = "usuario no encontrado";
}

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conexion->close();
?>