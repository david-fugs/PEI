<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

    include("../../../conexion.php");
    date_default_timezone_set("America/Bogota");

    $obs_dllo_integ         = isset($_POST['obs_dllo_integ']) ? strtoupper($_POST['obs_dllo_integ']) : '';
    // Usar el id_cole de la sesion si no viene del POST o si el POST esta vacio
    $id_cole_post           = isset($_POST['id_cole']) ? $_POST['id_cole'] : '';
    $id_cole_final          = !empty($id_cole_post) ? $id_cole_post : $id_cole;
    $fecha_alta_dllo_integ  = date('Y-m-d H:i:s');
    $fecha_edit_dllo_integ  = '0000-00-00 00:00:00';
    $id_usu                 = $_SESSION['id'];

    // Validar que tenemos un id_cole valido
    if (empty($id_cole_final)) {
        echo "
            <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta charset='utf-8' />
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo obtener el ID del colegio. Por favor, inicie sesion nuevamente.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = '../../../index.php';
                        });
                    </script>
                </body>
            </html>
        ";
        exit;
    }

    try {
        $sql = "INSERT INTO dllo_integ (obs_dllo_integ, id_cole, fecha_alta_dllo_integ, fecha_edit_dllo_integ, id_usu) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sissi", $obs_dllo_integ, $id_cole_final, $fecha_alta_dllo_integ, $fecha_edit_dllo_integ, $id_usu);
        $resultado = $stmt->execute();

        if (!$resultado) {
            throw new Exception("Error al guardar en la base de datos: " . $stmt->error);
        }

        $id_insert = $mysqli->insert_id;
        
        // Manejo de archivos
        $archivos_subidos = 0;
        $archivos_error = 0;
        
        if (isset($_FILES["archivo"]) && !empty($_FILES["archivo"]['name'][0])) {
            //Como el elemento es un arreglo utilizamos foreach para extraer todos los valores
            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
                //Validamos que el archivo exista
                if($_FILES["archivo"]["name"][$key]) {
                    $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                    
                    $directorio = 'files/'.$id_insert.'/'; //Declaramos una variable con la ruta donde guardaremos los archivos
                    
                    //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($directorio)) {
                        if (!mkdir($directorio, 0777, true)) {
                            $error = error_get_last();
                            die("No se puede crear el directorio de extraccion. Error: " . ($error['message'] ?? 'Permisos insuficientes'));
                        }
                        chmod($directorio, 0777);
                    }
                    
                    $target_path = $directorio.$filename; //Indicamos la ruta de destino, asi como el nombre del archivo
                    
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(move_uploaded_file($source, $target_path)) { 
                        $archivos_subidos++;
                    } else {    
                        $archivos_error++;
                    }
                }
            }
        }

        // Respuesta exitosa con SweetAlert
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
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <title>PEI | SOFT</title>
                    <style>
                        .responsive {
                            max-width: 100%;
                            height: auto;
                        }
                        body {
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            min-height: 100vh;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .container {
                            background: white;
                            border-radius: 15px;
                            padding: 30px;
                            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <center>
                            <img src='../../../img/logo_educacion_fondo_azul.png' width='945' height='175' class='responsive'>
                            <div class='mt-4'>
                                <h3><i class='fas fa-check-circle text-success'></i> REGISTRO GUARDADO EXITOSAMENTE</h3>
                                <p class='text-muted'>El Seguimiento al Desarrollo Integral ha sido registrado correctamente</p>";
                                
        if ($archivos_subidos > 0) {
            echo "<p class='text-info'><i class='fas fa-file-upload'></i> Se subieron $archivos_subidos archivo(s) correctamente</p>";
        }
        if ($archivos_error > 0) {
            echo "<p class='text-warning'><i class='fas fa-exclamation-triangle'></i> $archivos_error archivo(s) no pudieron ser subidos</p>";
        }
        
        echo "
                                <div class='mt-4'>
                                    <button class='btn btn-primary' onclick='volverInicio()'>
                                        <i class='fas fa-arrow-left'></i> Volver al Desarrollo Integral
                                    </button>
                                </div>
                            </div>
                        </center>
                    </div>
                    
                    <script>
                        // Mostrar alerta de exito
                        Swal.fire({
                            title: 'Exito!',
                            text: 'El Seguimiento al Desarrollo Integral se ha guardado correctamente',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#667eea'
                        });
                        
                        function volverInicio() {
                            Swal.fire({
                                title: 'Redirigiendo...',
                                text: 'Volviendo al menu de Desarrollo Integral',
                                icon: 'info',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                window.location.href = 'addintegral.php';
                            });
                        }
                    </script>
                </body>
            </html>
        ";
        
    } catch (Exception $e) {
        // Manejo de errores con SweetAlert
        echo "
            <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta charset='utf-8' />
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al guardar los datos: " . addslashes($e->getMessage()) . "',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = 'addintegral1.php';
                        });
                    </script>
                </body>
            </html>
        ";
    }
?>