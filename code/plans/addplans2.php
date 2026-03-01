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

// DEBUG: Mostrar el SQL que se ejecuta
error_log("DEBUG addplans2.php - SQL: " . $sql);

$resultado = $mysqli->query($sql);

if ($resultado) {
    $id_insert = $mysqli->insert_id;

    foreach ($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
        if ($_FILES["archivo"]["name"][$key]) {
            $filename = $_FILES["archivo"]["name"][$key];
            $source = $_FILES["archivo"]["tmp_name"][$key];

            $directorio = 'files/' . $id_insert . '/';
            
            // Crear el directorio de manera recursiva si no existe
            if (!file_exists($directorio)) {
                if (!mkdir($directorio, 0777, true)) {
                    $error = error_get_last();
                    die("No se puede crear el directorio de extracción. Error: " . ($error['message'] ?? 'Permisos insuficientes'));
                }
                chmod($directorio, 0777); // Intentar ajustar permisos explícitamente
            }

            $dir = opendir($directorio);
            $target_path = $directorio . '/' . $filename;

            if (!move_uploaded_file($source, $target_path)) {
                echo "Ha ocurrido un error al subir el archivo.<br>";
            }
            closedir($dir);
        }
    }

    // Redirigir a la página de visualización de proyectos con mensaje de éxito
    $_SESSION['message'] = '✓ Se guardó de forma exitosa el proyecto/plan';
    $_SESSION['message_type'] = 'success';
    header("Location: ../proyect_transv/management/userViewProject.php");
    exit();
} else {
    $_SESSION['message'] = '❌ Error al insertar el proyecto/plan: ' . $mysqli->error;
    $_SESSION['message_type'] = 'danger';
    header("Location: addplans1.php");
    exit();
}
