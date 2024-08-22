<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="initial-scale=1, shrink-to-fit=no, width=device-width" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="icon" type="image/png" href="imgs/logo-mywebsite-urian-viera.svg">

    <link rel="stylesheet" type="text/css" href="css/material.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>Recibiendo Emails de clientes</title>
</head>

<body>

    <nav class="navbar navbar-light" style="background-color: #111 !important;">
        <a class="navbar-brand" href="#">
            <strong style="color: #46da9c">Dinosport</strong>
        </a>
    </nav>


    <div class="container mt-5" style="color: #0c8654">

        <?php
        header('Content-Type: text/html; charset=UTF-8');
        include('conexion.php');
        if (isset($_REQUEST['enviarform'])) {
            if (is_array($_REQUEST['correo'])) {
                $num_countries = count($_REQUEST['correo']);
                $columna   = 1;
        ?>
                <div class="row text-center mb-5">
                    <div class="col-12" style="color: #0c8654; font-weight: 100; font-size: 25px">
                        <p>Ha enviado un correo a: <strong>( <?php echo $num_countries; ?> )</strong> Registros
                            <hr>
                        </p>
                    </div>
                </div>


        <?php
                foreach ($_REQUEST['correo'] as $key => $emailCliente) {

                    $cliente = 'escalante';

                    $destinatario = trim($emailCliente); //Quitamos algun espacion en blanco
                    $asunto       = "Bienvenido a Dinosport";
                    $cuerpo = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
    <title>Envio de email de peticion de franquicia, escalante fatima, alexandra y portillo emanuel</title>';
                    $cuerpo .= ' 
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: "Roboto", sans-serif;
        font-size: 16px;
        font-weight: 300;
        color: #888;
        background-color:rgba(230, 225, 225, 0.5);
        line-height: 30px;
        text-align: center;
    }
    .contenedor{
        width: 80%;
        min-height:auto;
        text-align: center;
        margin: 0 auto;
        background: #ececec;
        border-top: 3px solid #E64A19;
    }
    .btnlink{
        padding:15px 30px;
        text-align:center;
        background-color:#cecece;
        color: crimson !important;
        font-weight: 600;
        text-decoration: blue;
    }
    .btnlink:hover{
        color: #fff !important;
    }
    .imgBanner{
        max-width:48%;
        margin-left: auto;
        margin-right: auto;
        display: block;
        padding:0px;
    }
    .misection{
        color: #34495e;
        margin: 4% 10% 2%;
        text-align: center;
        font-family: sans-serif;
    }
    .mt-5{
        margin-top:50px;
    }
    .mb-5{
        margin-bottom:50px;
    }
    </style>
';

                    $cuerpo .= '
</head>
<body>
    <div class="contenedor">
    <img class="imgBanner" src="img/OIG3.jpg">
    <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
    
    <tr>
        <td style="background-color: #ffffff;">
            <div class="misection">
                <h2 style="color: red; margin: 0 0 7px">Hola, ' . $cliente . '</h2>
                <p style="margin: 2px; font-size: 18px">te doy la Bienvenida a Dinosport, una empresa con elementos para los deportes al aire libre. </p>
            </div>
        </td>
    </tr>
</table>';

                    $cuerpo .= '
      </div>
    </body>
  </html>';

                    //Cabecera Obligatoria
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: WebDeveloper <escalanteagustina190@gmail.com>' . "\r\n";
                    $headers .= 'Cc: noresponder@pruebaroyalcanin.com.co' . "\r\n";

                    //OPCIONAR
                    $headers .= "Reply-To: ";
                    $headers .= "Return-path:";
                    $headers .= "Cc:";
                    $headers .= "Bcc:";

                    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
                        $proceso="respondido";
                        $notificacion="1";
                        $UpdateEmail = ("UPDATE franquicias SET notificacion=$notificacion proceso='$proceso'  WHERE gmail='" . $emailCliente . "' ");
                        $resultEmail = mysqli_query($conexion, $UpdateEmail);
                    }

                    echo '<div>' . $columna . "). " . $emailCliente . '</div>';
                    $columna++;
                }
            }
        }
        ?>

        <div class="row text-center mt-5 mb-5" style="color: #111">
            <div class="col-12">
                <a href="solifranquicias.php" class="btn btn-round btn-dark">Volver al Inicio</a>
            </div>
        </div>
    </div>

</body>

</html>