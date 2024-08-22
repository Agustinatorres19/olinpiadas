<?php
include "conexion.php";
include "adminicio.html";

$id = $_GET['id'];
$sql = "SELECT * FROM productos WHERE id_productos = $id";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <script src="https://kit.fontawesome.com/0b2ba1b6e4.js" crossorigin="anonymous"></script>
</head>
<body>
    <center>
        <h5>Modificar</h5>
        <form action="modificarmas.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
            <?php while ($datos = $result->fetch_object()) { ?>
                <div class="mb-2">
                    <input type="text" name="nombre" placeholder="Nombre..." value="<?= htmlspecialchars($datos->nombre, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>
                </div>
                <div class="mb-2">
                    <input type="text" name="precio" placeholder="Precio..." value="<?= htmlspecialchars($datos->precio, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>
                </div>
                <div class="mb-2">
                    <input type="text" name="descripcion" placeholder="Descripción..." value="<?= htmlspecialchars($datos->descripcion, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>
                </div>
                <div class="mb-2">
                    <img height="150px" src="data:image/jpg;base64,<?= base64_encode($datos->imagen); ?>" alt=""><br><br>
                </div>
                <div class="mb-2">
                    <input type="file" name="imagen"><br><br>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane fa-xl" style="color: #74C0FC;"></i> Enviar
                </button>
                <a href="productos1.php" class="btn btn-secondary">
                    <i class="fa-solid fa-person-walking-arrow-loop-left fa-flip-horizontal fa-2xl" style="color: #63E6BE;"></i> Volver
                </a>
            <?php } ?>
        </form>
    </center>
</body>
</html>
