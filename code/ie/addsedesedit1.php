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

    $ju_sede                =   $_POST['ju_sede'];
    $ju_primaria_sede       =   $_POST['ju_primaria_sede'];
    $ju_secundaria_sede     =   $_POST['ju_secundaria_sede'];
    $ju_media_sede          =   $_POST['ju_media_sede'];
    //echo $res_acad          =   $_POST['res_acad'];
    //echo $fec_res_acad      =   $_POST['fec_res_acad']."<br>";
    //$fecha_alta_acad    =   date('Y-m-d h:i:s');
    //$fecha_edit_acad    =   ('0000-00-00 00:00:00');
    //$id_usu             =   $_SESSION['id'];

    print_r($ju_sede)."<br>";
    print_r($ju_primaria_sede)."<br>";
    print_r($ju_secundaria_sede)."<br>";
    print_r($ju_media_sede)."<br>";
    //print_r($res_acad)."<br>";
    //print_r($fec_res_acad)."<br>";
    //print_r($fecha_alta_acad)."<br>";
    //print_r($fecha_edit_acad)."<br>";
    //print_r($id_usu)."<br>";

    if(isset($_POST['insertar']))
    {
        $items1 = ($_POST['ju_sede']);
        $items2 = ($_POST['ju_primaria_sede']);
        $items3 = ($_POST['ju_secundaria_sede']);
        $items4 = ($_POST['ju_media_sede']);
     
        ///////////// SEPARAR VALORES DE ARRAYS, EN ESTE CASO SON 4 ARRAYS UNO POR CADA INPUT (ID, NOMBRE, CARRERA Y GRUPO////////////////////)
        while(true) 
        {
            //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
            $item1 = current($items1);
            $item2 = current($items2);
            $item3 = current($items3);
            $item4 = current($items4);
            
            ////// ASIGNARLOS A VARIABLES ///////////////////
            $ju_sede=(( $item1 !== false) ? $item1 : ", &nbsp;");
            $ju_primaria_sede=(( $item2 !== false) ? $item2 : ", &nbsp;");
            $ju_secundaria_sede=(( $item3 !== false) ? $item3 : ", &nbsp;");
            $ju_media_sede=(( $item4 !== false) ? $item4 : ", &nbsp;");

            //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
            $valores='("'.$ju_sede.'","'.$ju_primaria_sede.'","'.$ju_secundaria_sede.'","'.$ju_media_sede.'"),';

            //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
            $valoresQ= substr($valores, 0, -1); 
            
            ///////// QUERY DE INSERCIÓN ////////////////////////////
            echo $sql = "UPDATE sedes (ju_sede, ju_primaria_sede, ju_secundaria_sede, ju_media_sede) 
            VALUES $valoresQ";

            
            $sqlRes=$mysqli->query($sql);

            
            // Up! Next Value
            $item1 = next( $items1 );
            $item2 = next( $items2 );
            $item3 = next( $items3 );
            $item4 = next( $items4 );
            
            // Check terminator
            if($item1 === false && $item2 === false && $item3 === false && $item4 === false) break;

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
                        <img src='../../img/gobersecre.png' width='300' height='141' class='responsive'>
                    
                    <div class='container'>
                        <br />
                        <h3><b><i class='fas fa-file-signature'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";

        $mysqli->close();
?>