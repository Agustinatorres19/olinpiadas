<?php
include 'adminicio.html';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0b2ba1b6e4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .product-img {
            width: 100%;  
            max-width: 200px;  
            height: auto;  
            object-fit: cover; 
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<?php
    session_start();
    if (isset($_SESSION['msj'])) {
        $respuesta = $_SESSION['msj'];
?>
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "<?php echo htmlspecialchars($respuesta, ENT_QUOTES, 'UTF-8'); ?>",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php
        unset($_SESSION['msj']);
    }
?>

<div class="container-fluid row">
    <form action="guar.php" method="post" enctype="multipart/form-data" class="col-12 col-md-4 p-3">
        <h3 class="text-center text-primary">Nuevo Producto</h3>
        <div class="mb-2">
            <label for="exampleInputNombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="exampleInputPrecio" class="form-label">Precio</label>
            <input type="text" name="precio" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="exampleInputDescripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" name="descripcion" required>
        </div>
        <div class="mb-2">
            <input type="file" name="imagen" class="form-control" required><br><br>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-paper-plane fa-xl" style="color: #74C0FC;"></i> Registrar
        </button>
    </form>

    <div class="col-12 col-md-8 p-4">
        <center>
            <h3 class="text-center text-secondary">Productos</h3>
        </center>
        <br><br>

        <!-- Formulario de búsqueda -->
        <form class="d-flex mb-4" method="GET" action="">
            <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar productos..." aria-label="Buscar" value="<?php echo htmlspecialchars($busqueda ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conexion.php";

                    // Obtener el término de búsqueda de la URL, si existe
                    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

                    // Preparar la consulta SQL con el término de búsqueda
                    $sql = "SELECT * FROM productos WHERE nombre LIKE ?";
                    $stmt = $conexion->prepare($sql);
                    $searchTerm = '%' . $busqueda . '%';
                    $stmt->bind_param('s', $searchTerm);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Mostrar los resultados
                    while ($datos = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($datos['id_productos'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($datos['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($datos['precio'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($datos['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><img class="product-img" src="data:image/jpg;base64,<?= base64_encode($datos['imagen']); ?>" alt=""></td>
                        <td>
                            <a href="modificar1.php?id=<?= htmlspecialchars($datos['id_productos'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-small btn-secondary" onclick="confirmModificar(event)"><i class="fa-solid fa-pen-to-square" style="color: #3cd7ec;"></i></a>
                            <a href="eliminarmas.php?id=<?= htmlspecialchars($datos['id_productos'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-small btn-danger" onclick="confirmEliminar(event)"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmEliminar(event) {
        event.preventDefault();  
        const href = event.currentTarget.href;
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;  
            }
        });
    }

    function confirmModificar(event) {
        event.preventDefault();  
        const href = event.currentTarget.href;
        Swal.fire({
            title: '¿Quieres modificar este registro?',
            text: "Asegúrate de que estás listo para modificar.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, modificar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;  
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
