<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

header("Content-Type: text/html;charset=utf-8");
$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole'];

include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$nombre_proy_plan       =   $_POST['nombre_proy_plan'];
$tipo_proy_plan         =   $_POST['tipo_proy_plan'];
$obs_proy_plan          =   $_POST['obs_proy_plan'];
$id_cole                 =   $_POST['id_cole'];
$fecha_alta_proy_plan   =   date('Y-m-d h:i:s');
$fecha_edit_proy_plan   =   ('0000-00-00 00:00:00');
$id_usu                  =   $_SESSION['id'];

$sql = "INSERT INTO proyectos_planes (nombre_proy_plan, tipo_proy_plan, obs_proy_plan, id_cole, fecha_alta_proy_plan, fecha_edit_proy_plan, id_usu) values ('$nombre_proy_plan', '$tipo_proy_plan', '$obs_proy_plan', '$id_cole', '$fecha_alta_proy_plan', '$fecha_edit_proy_plan', '$id_usu')";
$resultado = $mysqli->query($sql);

if ($resultado) {
    $id_insert = $mysqli->insert_id;

    foreach ($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
        if ($_FILES["archivo"]["name"][$key]) {
            $filename = $_FILES["archivo"]["name"][$key];
            $source = $_FILES["archivo"]["tmp_name"][$key];

            $directorio = 'files/' . $id_insert . '/';
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracción");
            }

            $dir = opendir($directorio);
            $target_path = $directorio . '/' . $filename;

            if (!move_uploaded_file($source, $target_path)) {
                echo "Ha ocurrido un error al subir el archivo.<br>";
            }
            closedir($dir);
        }
    }

    // Solo mostramos el HTML si el INSERT fue exitoso
    echo "
        <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta charset='utf-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                    <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                    <link href='../../fontawesome/css/all.css' rel='stylesheet'>
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
                        <img src='../../img/logo_educacion_fondo_azul.png' width='600' height='111' class='responsive'>
                    
                    <div class='container'>
                        <br />
                        <h3><b><i class='fas fa-check-circle'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
} else {
    echo "❌ Error al insertar el proyecto/plan: " . $mysqli->error;
}
