<?php
require "config/config.php";
require "config/db.php";

// Crear una instancia de la clase Database y obtener la conexión
$baseDatos = new Database();
$con = $baseDatos->conectar();

if (!$con) {
    die("Error: No se pudo conectar a la base de datos.");
}

$payment = $_GET['payment_id'] ?? null;
$fecha_nueva = date('Y-m-d H:i:s');
$status = $_GET['status'] ?? null;
$order_id = $_GET['merchant_order_id'] ?? null;
$plataforma = 'mercado pago';
$total = 0;

echo "<h3>Pago exitoso</h3>";
echo htmlspecialchars($payment) . '<br>';
echo htmlspecialchars($fecha_nueva) . '<br>';
echo htmlspecialchars($status) . '<br>';
echo htmlspecialchars($order_id) . '<br>';

try {
    // Insertar en la tabla 'compras'
    $sql = $con->prepare("INSERT INTO compras (id_transaccion, fecha, status, id_cliente, total, plataforma_de_pago) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$payment, $fecha_nueva, $status, $order_id, $total, $plataforma]);

    // Obtener el ID de la compra recién insertada
    $id_compra = $con->lastInsertId();

    if ($id_compra > 0) {
        $productos = isset($_SESSION["carrito"]["productos"]) ? $_SESSION["carrito"]["productos"] : null;

        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
                // Consultar producto
                $sql = $con->prepare("SELECT id_productos, nombre, precio FROM productos WHERE id_productos = ?");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                if ($row_prod) {
                    $precio = $row_prod["precio"];
                    $subtotal = $cantidad * $precio;
                    $total += $subtotal;

                    // Insertar en la tabla 'detalle_compras'
                    $sql_insert = $con->prepare("INSERT INTO datelle_compras (id_compra, id_producto, nombre, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
                    $sql_insert->execute([$id_compra, $clave, $row_prod['nombre'], $precio, $cantidad]);

                    // Insertar en la tabla 'peticion_compras'
                    $sql_peticion = $con->prepare("INSERT INTO peticion_compras (id_cliente, id_compra, id_producto, nombre, precio, cantidad, proceso) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $sql_peticion->execute([$order_id, $id_compra, $clave, $row_prod['nombre'], $precio, $cantidad, $status]);
                } else {
                    echo "Producto con ID $clave no encontrado.<br>";
                }
            }
            
            // Actualizar el total en la tabla 'compras'
            $sql_update = $con->prepare("UPDATE compras SET total = ? WHERE id_transaccion = ?");
            $sql_update->execute([$total, $payment]);
        }

        unset($_SESSION['carrito']);
        if ($productos == null) {
            header("Location:index.php");
            exit;
        }
    } else {
        echo "Error al insertar en la tabla 'compras'.<br>";
    }

} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>
