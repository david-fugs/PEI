<?php
    date_default_timezone_set("America/Bogota");
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEI | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

   	<?php
        include("../../conexion.php");

	    if(isset($_POST['btn-update']))
        {
            $cod_dane_cole       =   $_POST['cod_dane_cole'];
            $nit_cole            =   $_POST['nit_cole'];
            $nombre_cole         =   $_POST['nombre_cole'];
            $nombre_rector_cole  =   $_POST['nombre_rector_cole'];
            $tel_rector_cole     =   $_POST['tel_rector_cole'];
            $jor_1_cole          =   $_POST['jor_1_cole'];
            $jor_2_cole          =   $_POST['jor_2_cole'];
            $jor_3_cole          =   $_POST['jor_3_cole'];
            $jor_4_cole          =   $_POST['jor_4_cole'];
            $jor_5_cole          =   $_POST['jor_5_cole'];
            $jor_6_cole          =   $_POST['jor_6_cole'];
            $jor_7_cole          =   $_POST['jor_7_cole'];
            $jor_8_cole          =   $_POST['jor_8_cole'];
            $jor_9_cole          =   $_POST['jor_9_cole'];
            $jor_10_cole         =   $_POST['jor_10_cole'];
            $niv_1_cole          =   $_POST['niv_1_cole'];
            $niv_2_cole          =   $_POST['niv_2_cole'];
            $niv_3_cole          =   $_POST['niv_3_cole'];
            $niv_4_cole          =   $_POST['niv_4_cole'];
            $car_med_1_cole      =   $_POST['car_med_1_cole'];
            $car_med_2_cole      =   $_POST['car_med_2_cole'];
            $direccion_cole      =   $_POST['direccion_cole'];
            $corregimiento_cole  =   $_POST['corregimiento_cole'];
            $id_mun              =   $_POST['id_mun'];
            $tel1_cole           =   $_POST['tel1_cole'];
            $tel2_cole           =   $_POST['tel2_cole'];
            $email_cole          =   $_POST['email_cole'];
            $num_act_adm_cole    =   $_POST['num_act_adm_cole'];
            $fec_res_cole        =   $_POST['fec_res_cole'];
            $obs_cole            =   $_POST['obs_cole'];
            $fecha_edit_cole     =   date('Y-m-d H:i:s');
            $id_usu              =   $_SESSION['id'];

            // Nuevos campos para CICLOS
            $tiene_ciclos        =   isset($_POST['tiene_ciclos']) ? $_POST['tiene_ciclos'] : 0;
            $ciclo_0             =   isset($_POST['ciclo_0']) ? 1 : 0;
            $ciclo_1             =   isset($_POST['ciclo_1']) ? 1 : 0;
            $ciclo_2             =   isset($_POST['ciclo_2']) ? 1 : 0;
            $ciclo_3             =   isset($_POST['ciclo_3']) ? 1 : 0;
            $ciclo_4             =   isset($_POST['ciclo_4']) ? 1 : 0;
            $ciclo_5             =   isset($_POST['ciclo_5']) ? 1 : 0;
            $ciclo_6             =   isset($_POST['ciclo_6']) ? 1 : 0;

            // Nuevos campos para MODELOS EDUCATIVOS FLEXIBLES
            $modelo_escuela_nueva       =   isset($_POST['modelo_escuela_nueva']) ? 1 : 0;
            $modelo_aceleracion         =   isset($_POST['modelo_aceleracion']) ? 1 : 0;
            $modelo_post_primaria       =   isset($_POST['modelo_post_primaria']) ? 1 : 0;
            $modelo_caminar_secundaria  =   isset($_POST['modelo_caminar_secundaria']) ? 1 : 0;
            $modelo_pensar_secundaria   =   isset($_POST['modelo_pensar_secundaria']) ? 1 : 0;
            $modelo_media_rural         =   isset($_POST['modelo_media_rural']) ? 1 : 0;
            $modelo_pensar_media        =   isset($_POST['modelo_pensar_media']) ? 1 : 0;
            $modelo_otro                =   isset($_POST['modelo_otro']) ? 1 : 0;
            $modelo_otro_cual           =   isset($_POST['modelo_otro_cual']) ? $_POST['modelo_otro_cual'] : '';

            // Nuevos campos para ESPECIALIDADES DE MEDIA
            // Especialidades técnicas (pueden ser múltiples, se guardan separadas por comas)
            $especialidades_tecnica = '';
            if(isset($_POST['especialidades_tecnica']) && is_array($_POST['especialidades_tecnica'])) {
                $especialidades_array = array_filter($_POST['especialidades_tecnica'], function($value) {
                    return !empty(trim($value));
                });
                $especialidades_tecnica = implode(', ', $especialidades_array);
            }

            // Especialidad académica
            $especialidad_academica = isset($_POST['especialidad_academica']) ? $_POST['especialidad_academica'] : '';
           
            $update = "UPDATE colegios SET 
                nit_cole='".$nit_cole."', 
                nombre_cole='".$nombre_cole."', 
                nombre_rector_cole='".$nombre_rector_cole."', 
                tel_rector_cole='".$tel_rector_cole."', 
                jor_1_cole='".$jor_1_cole."', 
                jor_2_cole='".$jor_2_cole."', 
                jor_3_cole='".$jor_3_cole."', 
                jor_4_cole='".$jor_4_cole."', 
                jor_5_cole='".$jor_5_cole."', 
                jor_6_cole='".$jor_6_cole."', 
                jor_7_cole='".$jor_7_cole."', 
                jor_8_cole='".$jor_8_cole."', 
                jor_9_cole='".$jor_9_cole."', 
                jor_10_cole='".$jor_10_cole."', 
                niv_1_cole='".$niv_1_cole."', 
                niv_2_cole='".$niv_2_cole."', 
                niv_3_cole='".$niv_3_cole."', 
                niv_4_cole='".$niv_4_cole."', 
                car_med_1_cole='".$car_med_1_cole."', 
                car_med_2_cole='".$car_med_2_cole."', 
                direccion_cole='".$direccion_cole."', 
                corregimiento_cole='".$corregimiento_cole."', 
                id_mun='".$id_mun."', 
                tel1_cole='".$tel1_cole."', 
                tel2_cole='".$tel2_cole."', 
                email_cole='".$email_cole."', 
                num_act_adm_cole='".$num_act_adm_cole."', 
                fec_res_cole='".$fec_res_cole."', 
                obs_cole='".$obs_cole."',
                tiene_ciclos='".$tiene_ciclos."',
                ciclo_0='".$ciclo_0."',
                ciclo_1='".$ciclo_1."',
                ciclo_2='".$ciclo_2."',
                ciclo_3='".$ciclo_3."',
                ciclo_4='".$ciclo_4."',
                ciclo_5='".$ciclo_5."',
                ciclo_6='".$ciclo_6."',
                modelo_escuela_nueva='".$modelo_escuela_nueva."',
                modelo_aceleracion='".$modelo_aceleracion."',
                modelo_post_primaria='".$modelo_post_primaria."',
                modelo_caminar_secundaria='".$modelo_caminar_secundaria."',
                modelo_pensar_secundaria='".$modelo_pensar_secundaria."',
                modelo_media_rural='".$modelo_media_rural."',
                modelo_pensar_media='".$modelo_pensar_media."',
                modelo_otro='".$modelo_otro."',
                modelo_otro_cual='".$modelo_otro_cual."',
                especialidades_tecnica='".$especialidades_tecnica."',
                especialidad_academica='".$especialidad_academica."',
                fecha_edit_cole='".$fecha_edit_cole."', 
                id_usu='".$id_usu."' 
                WHERE cod_dane_cole='".$cod_dane_cole."'";

            $up = mysqli_query($mysqli, $update);

            $id_insert = $nit_cole;
            //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
            {
                //Validamos que el archivo exista
                if($_FILES["archivo"]["name"][$key])
                {
                    $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                    
                    $directorio = 'files/'.$id_insert.'/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    
                    //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($directorio))
                    {
                        mkdir($directorio, 0777, true) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    
                    $dir=opendir($directorio); //Abrimos el directorio de destino
                    $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                    
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(move_uploaded_file($source, $target_path))
                    { 
                        //echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
                    } 
                        else 
                        {    
                            echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                        }
                    closedir($dir); //Cerramos el directorio de destino
                }
            }


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
                            <link href='../../fontawesome/css/all.css' rel='stylesheet'>
                            <title>RISPRO | SOFT</title>
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
                                <h3><b><i class='fas fa-school'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                                <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                            </div>
                            </center>
                        </body>
                    </html>
        ";
        }
    ?>

</body>
</html>