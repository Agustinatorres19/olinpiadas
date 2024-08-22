<?php
$servername = "localhost";
$username = "root"; // Tu nombre de usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "dinocafe";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$gmail = $_POST['gmail'];
$tel = $_POST['tel'];
$zona = $_POST['zona'];

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO franquicias (nombre, apellido, gmail, tel, zona) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $gmail, $tel, $zona);

if ($stmt->execute()) {
    header("Location: extra.html");
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
