<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

    include("../../conexion.php");
    date_default_timezone_set("America/Bogota");

    $mision_ct          =   strtoupper($_POST['mision_ct']);
    $vision_ct          =   strtoupper($_POST['vision_ct']);
    $per_egr_ct         =   strtoupper($_POST['per_egr_ct']);
    $obj_ins_ct         =   strtoupper($_POST['obj_ins_ct']);
    $obs_ct             =   strtoupper($_POST['obs_ct']);
    $estado_ct          =   1;
    $fecha_alta_ct      =   date('Y-m-d h:i:s');
    $fecha_edit_ct      =   ('0000-00-00 00:00:00');
    $id_usu             =   $_SESSION['id'];

    $sql = "INSERT INTO componente_teleologico (mision_ct, vision_ct, per_egr_ct, obj_ins_ct, obs_ct, id_cole, estado_ct, fecha_alta_ct, fecha_edit_ct, id_usu) values ('$mision_ct', '$vision_ct', '$per_egr_ct', '$obj_ins_ct', '$obs_ct','$id_cole','$estado_ct', '$fecha_alta_ct', '$fecha_edit_ct', '$id_usu')";
    $resultado = $mysqli->query($sql);

    $id_insert = $id_cole;
     //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
    foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivo"]["name"][$key])
        {
            $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            
            // Ruta relativa y absoluta para guardar archivos
            $base_dir_rel = 'files/';
            $base_dir_abs = __DIR__ . '/' . $base_dir_rel;
            $directorio_rel = $base_dir_rel . $id_insert . '/';
            $directorio_abs = $base_dir_abs . $id_insert . '/'; //ruta absoluta

            // Asegura que la carpeta base 'files/' exista
            if (!file_exists($base_dir_abs)) {
                if (!mkdir($base_dir_abs, 0777, true)) {
                    die("No se puede crear el directorio base de archivos");
                }
            }

            // Crea el subdirectorio del id si no existe
            if (!file_exists($directorio_abs)) {
                if (!mkdir($directorio_abs, 0777, true)) {
                    die("No se puede crear el directorio de extracci&oacute;n");
                }
            }

            // Ruta absoluta de destino para mover el archivo
            $target_path_abs = $directorio_abs . $filename;

            // Mover archivo desde la ruta temporal a la absoluta
            if (move_uploaded_file($source, $target_path_abs)) {
                // archivo guardado correctamente
            } else {
                echo "Ha ocurrido un error al mover el archivo $filename, por favor inténtelo de nuevo.<br>";
            }
        }
    }

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
                        <img src='../../img/logo_educacion_fondo_azul.png' width='945' height='175' class='responsive'>
                    
                    <div class='container'>
                        <br />
                        <h3><b><i class='fas fa-check-circle'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>