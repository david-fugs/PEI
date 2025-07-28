<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
}

header("Content-Type: text/html;charset=utf-8");

include("../../conexion.php");
date_default_timezone_set("America/Bogota");

$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id_usu         = $_SESSION['id'];

$id_cole                 = $_POST['id_cole'];
$nombre_proy_trans       = $_POST['nombre_proy_trans'];
$tipo_proy_trans         = $_POST['tipo_proy_trans'];
$nombre_tipo_proy_trans  = $_POST['nombre_tipo_proy_trans'];
$obj_proy_trans          = $_POST['obj_proy_trans'];
$sos_proy_trans          = $_POST['sos_proy_trans'] ?? '';
$des_proy_trans          = $_POST['des_proy_trans'];
$gra_0_proy_trans        = $_POST['gra_0_proy_trans'];
$gra_1_proy_trans        = $_POST['gra_1_proy_trans'];
$gra_2_proy_trans        = $_POST['gra_2_proy_trans'];
$gra_3_proy_trans        = $_POST['gra_3_proy_trans'];
$gra_4_proy_trans        = $_POST['gra_4_proy_trans'];
$gra_5_proy_trans        = $_POST['gra_5_proy_trans'];
$gra_6_proy_trans        = $_POST['gra_6_proy_trans'];
$gra_7_proy_trans        = $_POST['gra_7_proy_trans'];
$gra_8_proy_trans        = $_POST['gra_8_proy_trans'];
$gra_9_proy_trans        = $_POST['gra_9_proy_trans'];
$gra_10_proy_trans       = $_POST['gra_10_proy_trans'];
$gra_11_proy_trans       = $_POST['gra_11_proy_trans'];
$obs_proy_trans          = $_POST['obs_proy_trans'];
$fecha_alta_proy_trans   = date('Y-m-d H:i:s');
$fecha_edit_proy_trans   = '0000-00-00 00:00:00';

$sql = "INSERT INTO proyectos_transversales (
    nombre_proy_trans, tipo_proy_trans, nombre_tipo_proy_trans, obj_proy_trans, sos_proy_trans, des_proy_trans,
    gra_0_proy_trans, gra_1_proy_trans, gra_2_proy_trans, gra_3_proy_trans, gra_4_proy_trans, gra_5_proy_trans,
    gra_6_proy_trans, gra_7_proy_trans, gra_8_proy_trans, gra_9_proy_trans, gra_10_proy_trans, gra_11_proy_trans,
    obs_proy_trans, id_cole, fecha_alta_proy_trans, fecha_edit_proy_trans, id_usu
) VALUES (
    '$nombre_proy_trans', '$tipo_proy_trans', '$nombre_tipo_proy_trans', '$obj_proy_trans', '$sos_proy_trans', '$des_proy_trans',
    '$gra_0_proy_trans','$gra_1_proy_trans','$gra_2_proy_trans','$gra_3_proy_trans','$gra_4_proy_trans','$gra_5_proy_trans',
    '$gra_6_proy_trans','$gra_7_proy_trans','$gra_8_proy_trans','$gra_9_proy_trans','$gra_10_proy_trans','$gra_11_proy_trans',
    '$obs_proy_trans', '$id_cole', '$fecha_alta_proy_trans', '$fecha_edit_proy_trans', '$id_usu'
)";

$resultado = $mysqli->query($sql);

if ($resultado) {
    $id_insert = $mysqli->insert_id;

    foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
        if($_FILES["archivo"]["name"][$key]) {
            $filename = $_FILES["archivo"]["name"][$key];
            $source = $_FILES["archivo"]["tmp_name"][$key];
            $base_dir = 'files/';
            $directorio = $base_dir . $id_insert . '/';

            // Asegura que la carpeta base 'files/' exista
            if (!file_exists($base_dir)) {
                mkdir($base_dir, 0777, true) or die("No se puede crear el directorio base");
            }

            // Ahora crea el subdirectorio del proyecto
            if(!file_exists($directorio)) {
                mkdir($directorio, 0777, true) or die("No se puede crear el directorio del proyecto");
            }

            $target_path = $directorio . $filename;
            move_uploaded_file($source, $target_path);
        }
    }

    // Mostrar mensaje solo si se insertó correctamente
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
        <style>.responsive { max-width: 100%; height: auto; }</style>
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
    </html>";
} else {
    echo "❌ Error al guardar en la base de datos: " . $mysqli->error;
}
?>
