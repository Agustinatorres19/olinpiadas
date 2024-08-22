<?php
define("CLIENT_ID", "AQxaYD1ue7yPhjbNiRt9woe9aL2Bq17nDcpK7QMMoO-im4Cp7MJsD26FprKMnm6kzXDBocxIZscM7Fwo");
define("TOKEN_MP", "APP_USR-8398035191248558-081502-26d46be3282b205b2c1156d28aaacf08-1948231322");
define("KEY_TOKEN", "TWT.kra-091*");

define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION["carrito"]["productos"])){
    $num_cart = count($_SESSION["carrito"]["productos"]);
}
?>