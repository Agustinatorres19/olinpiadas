<?php
include'adminicio.html';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0b2ba1b6e4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    session_start();
    if (isset($_SESSION['msj'])) {
      $respuesta=$_SESSION['msj'];
    }
    ?>
 <script>
   Swal.fire({
    position: "top-end",
    icon: "success",
    title: "<?php echo $respuesta ?>",
    showConfirmButton: false,
    timer: 1500
    });
  </script>
 <?php
   unset($_SESSION['msj']);
 ?>
 <div class="container-fluid row">
 <form action="registroadmin.php" method="post" class="col-4 p-3">
    <h3 class="text-center text-primary">nuevo administrador</h3>
 <div class="mb-2">
    <label for="exampleInputPassword1" class="form-label">nombre</label>
    <input type="text" name="nombre" class="form-control">
  </div>
  <div class="mb-2">
    <label for="exampleInputPassword1" class="form-label">apellido</label>
    <input type="text" name="apellido" class="form-control">
  </div>
   <div class="mb-2">
     <label for="exampleInputEmail1" class="form-label">Email</label>
     <input type="email" class="form-control" name="email">
  </div>
  <div class="mb-2">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="clave">
  </div>
  <button type="submit"><i class="fa-solid fa-paper-plane fa-xl" style="color: #74C0FC;"></i>registrar</button>
 </form>
 <div class="col-8 p-4">
  <center>
  <h3 class="text-center text-secondary"> administradores</h3>
  </center>
  <br><br>
 <table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">nombre</th>
      <th scope="col">apellido</th>
      <th scope="col">  </th>
    </tr>
  </thead>
  <tbody>
    <?php
    include "conexion.php";
    $sql=$conexion->query("select*from administradores");
    while ($datos=$sql->fetch_object()) { ?>
     <tr>
      <td><?= $datos->id_administradores ?></td>
      <td><?= $datos->nombre ?></td>
      <td><?= $datos->apellido ?></td>

      <td>
        <a href="eliminaradmin.php?id=<?= $datos->id_administradores ?>" onclick="return advertencia()" class="btn btn-small btn-danger" ><i class="fa-solid fa-trash"></i></a>
      </td>
    </tr>
  <?php }
    ?>
    <script>
      function advertencia() {
        var not=confirm("estas seguro que quieres eliminar");
        return not;
      }
    </script>
   
  </tbody>
</table>
   
 </div>
 </div>

 
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>