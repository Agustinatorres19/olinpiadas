<?php
require "config/config.php";
require "config/db.php";
$db = new Database();
$con = $db->conectar();

// Obtenemos el valor del filtro si es que existe
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

$sql = $con->prepare("SELECT * FROM productos WHERE nombre LIKE :busqueda");
$sql->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinosport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a href="#" class="navbar-brand" style="color: lightgreen;">
    <strong>Dinosport</strong>
</a>


      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="nosotros.html" class="nav-link active">nosotros</a>
            </li>
            <li class="nav-item">
                <a href="franquicias.html" class="nav-link active">Franquicias</a>
            </li>
            <li class="nav-item">
                <a href="locales.html" class="nav-link active">ubicacion</a>
            </li>
            <li class="nav-item">
                <a href="noticias.html" class="nav-link active">noticias</a>
            </li>
            <li class="nav-item">
                <a href="admin/admin.php" class="nav-link active">Admin</a>
            </li>
        </ul>
        <a href="checkout.php" class="btn btn-primary">
            Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
      </div>
    </div>
  </div>
</header>

<main>
    <div class="container mt-3">
        <!-- Buscador -->
        <form class="d-flex mb-4" method="GET" action="">
            <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar productos..." aria-label="Buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>

        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1">
            <?php foreach($resultado as $row) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><?php echo $row["nombre"]; ?></h5>
                                <p class="card-text mb-0"><?php echo number_format($row["precio"], 2, ".", ","); ?></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-sm btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#modalDetalles<?php echo $row['id_productos']; ?>">
                                    Más detalles
                                </button>
                                <button class="btn btn-sm btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id_productos']; ?>, '<?php echo hash_hmac('sha1', $row['id_productos'], KEY_TOKEN); ?>')">
                                    Agregar al Carrito
                                </button>
                            </div>
    o                    </div>
                    </div>
                </div>

        <!-- Modal -->
        <div class="modal fade" id="modalDetalles<?php echo $row['id_productos']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['nombre']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <img 
                  src="data:image/jpg;base64, <?php echo base64_encode($row['imagen']); ?>"
                  class="img-fluid"
                  alt="<?php echo $row['nombre']; ?>"
                  
                >
                <p class="mt-3"><?php echo $row['descripcion']; ?></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
    </div>
    </div>  
</main>

<script>
    function addProducto(id, token){
        let url = "clases/carrito.php"
        let formData = new FormData()
        formData.append("id_productos", id)
        formData.append("token", token)

        fetch(url, {
            method: "POST",
            body: formData,
            mode:"cors"
        }).then(response => response.json())
        .then(data => {
            if (data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
