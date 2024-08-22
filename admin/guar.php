<?php
include "conexion.php";

// Verificar si el formulario ha sido enviado y si el archivo 'imagen' fue subido correctamente
if (isset($_POST['nombre'], $_POST['precio'], $_POST['descripcion'], $_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    
    // Asegurarse de que el archivo no esté vacío antes de intentar leerlo
    $Imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    // Consulta SQL para insertar los datos en la tabla 'productos'
    $sql = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES ('$nombre', '$precio', '$descripcion', '$Imagen')";

    // Ejecutar la consulta
    $result = $conexion->query($sql);

    // Verificar si la inserción fue exitosa
    if ($result) {
        header("Location: productos1.php"); // Redirigir si se guardó correctamente
    } else {
        echo "No se guardó"; // Mensaje de error si no se pudo guardar
    }
} else {
    echo "Error al subir la imagen o datos incompletos"; // Mensaje de error si faltan datos o hay problemas con la imagen
}
?>
