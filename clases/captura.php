<?php

require "../config/config.php";
require "../config/db.php";
session_start(); // Asegúrate de iniciar la sesión

$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos)) {

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];
    $plataforma = 'paypal';

    try {
        // Insertar en la tabla 'compras'
        $sql = $con->prepare("INSERT INTO compras (id_transaccion, fecha, status, email, id_cliente, total, plataforma_de_pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total, $plataforma]);

        $id_compra = $con->lastInsertId();

        if ($id_compra > 0) {

            $productos = isset($_SESSION["carrito"]["productos"]) ? $_SESSION["carrito"]["productos"] : null;

            if ($productos != null) {
                foreach ($productos as $clave => $cantidad) {
                    // Consultar el producto
                    $sql = $con->prepare("SELECT id_productos, nombre, precio FROM productos WHERE id_productos = ?");
                    $sql->execute([$clave]);
                    $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                    if ($row_prod) {
                        $precio = $row_prod["precio"];
                        $subtotal = $cantidad * $precio;

                        // Insertar en la tabla 'detalle_compras'
                        $sql_insert = $con->prepare("INSERT INTO datelle_compras (id_compra, id_producto, nombre, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
                        $sql_insert->execute([$id_compra, $clave, $row_prod['nombre'], $precio, $cantidad]);

                        // Insertar en la tabla 'peticion_compras'
                        $sql_peticiones = $con->prepare("INSERT INTO peticion_compras (id_cliente, id_compra, id_producto, nombre, precio, cantidad, proceso) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $proceso = 'approved';
                        $sql_peticiones->execute([$id_cliente, $id_compra, $clave, $row_prod['nombre'], $precio, $cantidad, $proceso]);

                    } else {
                        echo "Producto con ID $clave no encontrado.<br>";
                    }
                }

                // Elimina el carrito
                unset($_SESSION['carrito']);
                
                // Redirige a index.php
                header("Location: index.php");
                exit;
            } else {
                echo "No hay productos en el carrito.<br>";
            }

        } else {
            echo "No se pudo obtener el ID de la compra recién insertada.<br>";
        }

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
} else {
    echo "Datos no válidos recibidos.<br>";
}
?>
