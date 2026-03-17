<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

    include("../../conexion.php");
    date_default_timezone_set("America/Bogota");

    $fecha_seg       =     date('Y-m-d h:i:s');
    $tipo_seg        =     strtoupper($_POST['tipo_seg']);
    $obs_seg         =     strtoupper($_POST['obs_seg']);
    $id_cole          =     $_POST['id_cole'];
    $fecha_alta_seg  =     date('Y-m-d h:i:s');
    $fecha_edit_seg  =     ('0000-00-00 00:00:00');
    $id_usu           =     $_SESSION['id'];

    $sql = "INSERT INTO seguimiento (fecha_seg, tipo_seg, obs_seg, id_cole, fecha_alta_seg, fecha_edit_seg, id_usu) values ('$fecha_seg', '$tipo_seg', '$obs_seg', '$id_cole', '$fecha_alta_seg', '$fecha_edit_seg', '$id_usu')";
    $resultado = $mysqli->query($sql);

    echo "
        <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                    <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
                    <title>PEI | SOFT</title>
                    <style>
                        .responsive {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
                </head>
                <body>
                    <center>
                        <img src='../../img/logo_educacion_fondo_azul.png' width='945' height='175' class='responsive'>
                    
                    <div class='container'>
                        <br />
                        <h3><b><i class='fas fa-check-circle'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='addobservaciones.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>