<?php 
include 'adminicio.html';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-secondary bg-secondary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="entregar.php">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="adm.php">Entregados</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
session_start();
if (isset($_SESSION['msj'])) {
    $respuesta = htmlspecialchars($_SESSION['msj'], ENT_QUOTES, 'UTF-8');
?>
    <script>
        Swal.fire("<?php echo $respuesta ?>");
    </script>
<?php
    unset($_SESSION['msj']);
}
?>
<div class="col-12 col-md-8 p-4">
    <!-- Formulario de búsqueda -->
    <form class="d-flex" method="GET" action="">
        <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar productos..." aria-label="Buscar" value="<?php echo htmlspecialchars($busqueda ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Petición</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Compra</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Acciones</th>
                </tr>
                <tr style="height: 20px;"><td colspan="8"></td></tr>
            </thead>
            <tbody>
                <?php
                include "conexion.php";

                // Obtener el término de búsqueda de la URL, si existe
                $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

                // Preparar la consulta SQL con el término de búsqueda y filtrar por proceso "aprobado"
                $sql = "SELECT * FROM peticion_compras WHERE nombre LIKE ? AND proceso = 'enviando'";
                $stmt = $conexion->prepare($sql);
                $searchTerm = '%' . $busqueda . '%';
                $stmt->bind_param('s', $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();

                // Mostrar los resultados
                while ($datos = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= htmlspecialchars($datos['id_peticiones_compras'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($datos['id_cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($datos['id_compra'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($datos['id_producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($datos['precio'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($datos['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="recibido.php?id=<?= htmlspecialchars($datos['id_peticiones_compras'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-small btn-secondary" onclick="confirmModificar(event)">Entregado</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmModificar(event) {
        event.preventDefault();  
        const href = event.currentTarget.href;
        console.log(href);  // Mostrar la URL en la consola del navegador para depuración
        Swal.fire({
            title: '¿El pedido ha sido entregado?',
            text: "Asegúrate de que este pedido se entrego.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;  
            }
        });
    }
</script>

</body>
</html>
