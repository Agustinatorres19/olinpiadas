<?php
include "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    // Recuperar la imagen actual del producto
    $stmt = $conexion->prepare("SELECT imagen FROM productos WHERE id_productos = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $imagenActual = $result->fetch_object()->imagen;
    } else {
        echo "No se encontró el producto.";
        exit();
    }

    // Manejo de la imagen
    if (!empty($_FILES['imagen']['tmp_name'])) {
        $fileType = $_FILES['imagen']['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (in_array($fileType, $allowedTypes)) {
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $imagen = $conexion->real_escape_string($imagen);
        } else {
            echo "Tipo de archivo no permitido.";
            exit();
        }
    } else {
        $imagen = $imagenActual;
    }

    // Actualizar el producto en la base de datos
    $sql = "UPDATE productos SET nombre=?, precio=?, descripcion=?, imagen=? WHERE id_productos=?";
    $stmt = $conexion->prepare($sql);
    // Cambiar el tipo de parámetro para la imagen a 'b' (binary)
    $stmt->bind_param("ssdsi", $nombre, $precio, $descripcion, $imagen, $id);

    if ($stmt->execute()) {
        $_SESSION['msj'] = 'Producto actualizado con éxito.';
        header("Location: productos1.php");
        exit();
    } else {
        echo "No se pudo actualizar el producto: " . $stmt->error;
    }
} else {
    echo "Acceso inválido";
}
?>
