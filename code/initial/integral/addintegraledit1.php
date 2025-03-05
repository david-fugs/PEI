<?php
    date_default_timezone_set("America/Bogota");
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEI | SOFT</title>
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

   	<?php
        include("../../../conexion.php");

	    if(isset($_POST['btn-update']))
        {
            $id_dllo_integ          =   $_POST['id_dllo_integ'];
            $obs_dllo_integ         =   strtoupper($_POST['obs_dllo_integ']);
            $id_cole                =   $_POST['id_cole'];
            $fecha_edit_dllo_integ  =   date('Y-m-d h:i:s');
            $id_usu                 =   $_SESSION['id'];
           
            $update = "UPDATE dllo_integ SET obs_dllo_integ='".$obs_dllo_integ."', id_cole='".$id_cole."', fecha_edit_dllo_integ='".$fecha_edit_dllo_integ."', id_usu='".$id_usu."' WHERE id_dllo_integ='".$id_dllo_integ."'";

            $up = mysqli_query($mysqli, $update);

            $id_insert = $id_dllo_integ;
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
                            <meta charset='utf-8' />
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                            <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                            <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                            <link rel='stylesheet' href='../../../css/bootstrap.min.css'>
                            <link href='../../../fontawesome/css/all.css' rel='stylesheet'>
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
                                <img src='../../../img/logo_educacion_fondo_azul.png' width='945' height='175' class='responsive'>
                            
                            <div class='container'>
                                <br />
                                <h3><b><i class='fas fa-check-circle'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                                <p align='center'><a href='../../../access.php'><img src='../../../img/atras.png' width=96 height=96></a></p>
                            </div>
                            </center>
                        </body>
                    </html>
        ";
        }
    ?>

</body>
</html>