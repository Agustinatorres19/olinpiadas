
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
   Swal.fire("<?php echo $respuesta ?>");
 </script>
 <?php
   unset($_SESSION['msj']);
 ?>
    <div class="container">
        <i style="--clr:#00ff0a;"></i>
        <i style="--clr:#ff0057;"></i>
        <i style="--clr:#fffd44;"></i>
        <div class="login">
            <h2>iniciar sesion</h2>
            <form action="verficar.php" method="post">
            <div class="inputBox">
                <input type="text" name="email" placeholder="correo usuario">
            </div>
            <br>
            <div class="inputBox">
                <input type="text" name="clave" placeholder="clave">
            </div>
            <br>
            <div class="inputBox">
                <input type="submit" value="iniciar">
            </div>
            <br>
            </form>
            
        </div>
    </div>
</body>
</html>