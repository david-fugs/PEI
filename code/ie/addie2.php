<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];

    include("../../conexion.php");
    date_default_timezone_set("America/Bogota");

    $cod_dane_cole       =   $_POST['cod_dane_cole'];
    $nit_cole            =   $_POST['nit_cole'];
    $nombre_cole         =   strtoupper($_POST['nombre_cole']);
    $nombre_rector_cole  =   strtoupper($_POST['nombre_rector_cole']);
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
    $direccion_cole      =   strtoupper($_POST['direccion_cole']);
    $corregimiento_cole  =   strtoupper($_POST['corregimiento_cole']);
    $id_mun              =   $_POST['id_mun'];
    $tel1_cole           =   $_POST['tel1_cole'];
    $tel2_cole           =   $_POST['tel2_cole'];
    $email_cole          =   $_POST['email_cole'];
    $num_act_adm_cole    =   $_POST['num_act_adm_cole'];
    $fec_res_cole        =   $_POST['fec_res_cole'];
    $obs_cole            =   strtoupper($_POST['obs_cole']);
    $estado_cole         =   1;
    $fecha_alta_cole     =   date('Y-m-d h:i:s');
    $fecha_edit_cole     =   ('0000-00-00 00:00:00');
    $id_usu              =   $_SESSION['id'];

    $sql = "INSERT INTO colegios (cod_dane_cole, nit_cole, nombre_cole, nombre_rector_cole, tel_rector_cole, jor_1_cole, jor_2_cole, jor_3_cole, jor_4_cole, jor_5_cole, jor_6_cole, jor_7_cole, jor_8_cole, jor_9_cole, jor_10_cole, niv_1_cole, niv_2_cole, niv_3_cole, niv_4_cole, car_med_1_cole, car_med_2_cole, direccion_cole, corregimiento_cole, id_mun, tel1_cole, tel2_cole, email_cole, num_act_adm_cole, fec_res_cole, obs_cole, estado_cole, fecha_alta_cole, fecha_edit_cole, id_usu) values ('$cod_dane_cole', '$nit_cole', '$nombre_cole', '$nombre_rector_cole', '$tel_rector_cole', '$jor_1_cole', '$jor_2_cole','$jor_3_cole','$jor_4_cole','$jor_5_cole', '$jor_6_cole', '$jor_7_cole', '$jor_8_cole', '$jor_9_cole','$jor_10_cole', '$niv_1_cole', '$niv_2_cole', '$niv_3_cole', '$niv_4_cole', '$car_med_1_cole', '$car_med_2_cole', '$direccion_cole', '$corregimiento_cole', '$id_mun', '$tel1_cole', '$tel2_cole', '$email_cole', '$num_act_adm_cole', '$fec_res_cole', '$obs_cole','$estado_cole', '$fecha_alta_cole', '$fecha_edit_cole', '$id_usu')";
    $resultado = $mysqli->query($sql);

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
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
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
?>