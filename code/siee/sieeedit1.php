<?php
    date_default_timezone_set("America/Bogota");
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
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
            $id_siee            =   $_POST['id_siee'];
            $preg1_siee         =   $_POST['preg1_siee'];
            $preg2_siee         =   $_POST['preg2_siee'];
            $preg3_siee         =   $_POST['preg3_siee'];
            $preg3_1_siee       =   $_POST['preg3_1_siee'];
            if($_POST['preg3_1_siee']==""){$preg3_1_siee=0;}
            $preg3_2_siee       =   $_POST['preg3_2_siee'];
            if($_POST['preg3_2_siee']==""){$preg3_2_siee="0000-00-00";}
            $preg4_siee         =   strtoupper($_POST['preg4_siee']);
            $preg5_siee         =   $_POST['preg5_siee'];
            $preg6_1_siee       =   strtoupper($_POST['preg6_1_siee']);
            $preg6_2_siee       =   strtoupper($_POST['preg6_2_siee']);
            $preg6_3_siee       =   strtoupper($_POST['preg6_3_siee']);
            $preg6_4_siee       =   strtoupper($_POST['preg6_4_siee']);
            $preg6_5_siee       =   strtoupper($_POST['preg6_5_siee']);
            $preg7_siee         =   strtoupper($_POST['preg7_siee']);
            $preg8_siee         =   $_POST['preg8_siee'];
            $preg8_1_siee       =   strtoupper($_POST['preg8_1_siee']);
            $preg9_siee         =   $_POST['preg9_siee'];
            $preg9_1_siee       =   strtoupper($_POST['preg9_1_siee']);
            $preg10_siee        =   $_POST['preg10_siee'];
            $preg10_1_siee      =   strtoupper($_POST['preg10_1_siee']);
            $preg11_siee        =   $_POST['preg11_siee'];
            $preg11_1_siee      =   strtoupper($_POST['preg11_1_siee']);
            $preg12_siee        =   $_POST['preg12_siee'];
            $preg12_1_siee      =   strtoupper($_POST['preg12_1_siee']);
            $obs_siee           =   strtoupper($_POST['obs_siee']);
            $id_cole            =   $_POST['id_cole'];
            $fecha_edit_siee    =   date('Y-m-d h:i:s');
            $id_usu             =   $_SESSION['id'];

           $update = "UPDATE siee SET preg1_siee='".$preg1_siee."', preg2_siee='".$preg2_siee."', preg3_siee='".$preg3_siee."', preg3_1_siee='".$preg3_1_siee."', preg3_2_siee='".$preg3_2_siee."', preg4_siee='".$preg4_siee."', preg5_siee='".$preg5_siee."', preg6_1_siee='".$preg6_1_siee."', preg6_2_siee='".$preg6_2_siee."', preg6_3_siee='".$preg6_3_siee."', preg6_4_siee='".$preg6_4_siee."', preg6_5_siee='".$preg6_5_siee."', preg7_siee='".$preg7_siee."', preg8_siee='".$preg8_siee."', preg8_1_siee='".$preg8_1_siee."', preg9_siee='".$preg9_siee."', preg9_1_siee='".$preg9_1_siee."', preg10_siee='".$preg10_siee."', preg10_1_siee='".$preg10_1_siee."', preg11_siee='".$preg11_siee."', preg11_1_siee='".$preg11_1_siee."', preg12_siee='".$preg12_siee."', preg12_1_siee='".$preg12_1_siee."', obs_siee='".$obs_siee."', id_cole='".$id_cole."', fecha_edit_siee='".$fecha_edit_siee."', id_usu='".$id_usu."' WHERE id_siee='".$id_siee."'";

            $up = mysqli_query($mysqli, $update);

            $id_insert = $id_cole;
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
                                <img src='../../img/logo_educacion_fondo_azul.png' width='945' height='175' class='responsive'>
                            
                            <div class='container'>
                                <br />
                                <h3><b><i class='fas fa-check-circle'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
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