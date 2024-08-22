<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "olinpiadas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$gmail = $_POST['gmail'];
$zona = $_POST['zona'];

// Insertar datos en la tabla franquicia
$sql = "INSERT INTO franquicia (nombre, apellido, gmail, zona) VALUES ('$nombre', '$apellido', '$gmail', '$zona')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            Swal.fire({
              icon: 'success',
              title: '¡Registro exitoso!',
              text: 'La información ha sido enviada con éxito.'
            }).then(function() {
                window.location = 'formulario_registro.html';
            });
          </script>";
} else {
    echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Hubo un problema al enviar la información.'
            });
          </script>";
}

$conn->close();
?>
