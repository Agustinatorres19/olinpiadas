<?php

require "../config/config.php";
require "../config/db.php";

if(isset($_POST["action"])){

    $action = $_POST['action'];
    $id_productos = isset($_POST['id_productos']) ? $_POST['id_productos'] : 0;

    if($action == 'agregar'){
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id_productos, $cantidad);
        if($respuesta > 0){
            $datos["ok"] = true;
        }else{
            $datos["ok"] = false;
        }
        $datos["sub"] = MONEDA . number_format($respuesta, 2, ".", ",");
    } else if($action == "eliminar"){
        $datos["ok"] = eliminar($id_productos);
    } else{
        $datos["ok"] = false;
    }
}else{
    $datos["ok"] = false;
}
echo json_encode($datos);

function agregar($id_productos, $cantidad){
    $res = 0;
    if($id_productos > 0 && $cantidad > 0 && is_numeric($cantidad)){
        if(isset($_SESSION["carrito"]["productos"]["$id_productos"])){
            $_SESSION["carrito"]["productos"]["$id_productos"] = $cantidad;

            $db = new Database();
            $con = $db->conectar();

            $sql = $con->prepare("SELECT precio FROM productos WHERE id_productos=? LIMIT 1");
            $sql->execute([$id_productos]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row["precio"];
            $res = $cantidad * $precio;

            return $res;
        }
    }else{
        return $res;
    }
}


function eliminar($id_productos){
    if ($id_productos > 0){
        if(isset($_SESSION["carrito"]["productos"]["$id_productos"])){
            unset($_SESSION["carrito"]["productos"]["$id_productos"]);
            return true;
        }
    } else{
        return false;
    }
}

?>