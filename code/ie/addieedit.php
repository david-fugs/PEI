<?php
    
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
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEI | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body >
   	<?php
        include("../../conexion.php");
	    $cod_dane_cole  = $_GET['cod_dane_cole'];
	    if(isset($_GET['cod_dane_cole']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM colegios WHERE cod_dane_cole = '$cod_dane_cole'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo_educacion_fondo_azul.png' width="600" height="111" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fas fa-school"></i> ACTUALIZAR INFORMACIÓN DEL ESTABLECIMIENTO EDUCATIVO</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='addieedit1.php' enctype="multipart/form-data" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="cod_dane_cole">* CÓDIGO DANE:</label>
                        <input type='number' name='cod_dane_cole' class='form-control' readonly value='<?php echo $row['cod_dane_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="nit_cole">* No. NIT (ejemplo: 910420899-9):</label>
                        <input type='text' name='nit_cole' class='form-control' maxlength="11" minlength="11" required value='<?php echo $row['nit_cole']; ?>' />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="nombre_cole">* NOMBRE DEL ESTABLECIMIENTO EDUCATIVO:</label>
                        <input type='text' name='nombre_cole' class='form-control' id="nombre_cole" required style="text-transform:uppercase;" value='<?php echo $row['nombre_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="direccion_cole">* DIRECCIÓN:</label>
                        <input type='text' name='direccion_cole' id="direccion_cole" class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['direccion_cole']; ?>' />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="nombre_rector_cole">* NOMBRE DEL RECTOR:</label>
                        <input type='text' name='nombre_rector_cole' class='form-control' id="nombre_rector_cole" required style="text-transform:uppercase;" value='<?php echo $row['nombre_rector_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="tel_rector_cole">* TELÉFONO DE CONTACTO RECTOR:</label>
                        <input type='text' name='tel_rector_cole' id="tel_rector_cole" class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['tel_rector_cole']; ?>' />
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #04547c; border-radius: 5px;">
            <h4><b><CENTER>JORNADAS</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">JORNADA ÚNICA:</label>
                        <select class="form-control" name="jor_1_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_1_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_1_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">COMPLETA:</label>
                        <select class="form-control" name="jor_2_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_2_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_2_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">COMPLETA Y FIN DE SEMANA:</label>
                        <select class="form-control" name="jor_3_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_3_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_3_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">COMPLETA Y NOCTURNA:</label>
                        <select class="form-control" name="jor_4_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_4_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_4_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">COMPLETA, NOCTURNA Y FIN DE SEMANA</label>
                        <select class="form-control" name="jor_5_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_5_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_5_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA:</label>
                        <select class="form-control" name="jor_6_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_6_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_6_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA Y FIN DE SEMANA:</label>
                        <select class="form-control" name="jor_7_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_7_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_7_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA Y NOCTURNA:</label>
                        <select class="form-control" name="jor_8_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_8_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_8_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA, NOCTURNA Y FIN DE SEMANA:</label>
                        <select class="form-control" name="jor_9_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_9_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_9_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">OTRA:</label>
                        <select class="form-control" name="jor_10_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_10_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_10_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <h4><b><CENTER>MODELOS EDUCATIVOS FLEXIBLES</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label><b>Modelos (puede seleccionar uno o varios):</b></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_escuela_nueva" id="modelo_escuela_nueva" value="1" <?php if(isset($row['modelo_escuela_nueva']) && $row['modelo_escuela_nueva']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_escuela_nueva">
                                Escuela Nueva
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_aceleracion" id="modelo_aceleracion" value="1" <?php if(isset($row['modelo_aceleracion']) && $row['modelo_aceleracion']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_aceleracion">
                                Aceleración del Aprendizaje
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_post_primaria" id="modelo_post_primaria" value="1" <?php if(isset($row['modelo_post_primaria']) && $row['modelo_post_primaria']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_post_primaria">
                                Post Primaria
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_caminar_secundaria" id="modelo_caminar_secundaria" value="1" <?php if(isset($row['modelo_caminar_secundaria']) && $row['modelo_caminar_secundaria']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_caminar_secundaria">
                                Caminar en Secundaria
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_pensar_secundaria" id="modelo_pensar_secundaria" value="1" <?php if(isset($row['modelo_pensar_secundaria']) && $row['modelo_pensar_secundaria']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_pensar_secundaria">
                                Modelo Pedagógico Pensar Secundaria
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_media_rural" id="modelo_media_rural" value="1" <?php if(isset($row['modelo_media_rural']) && $row['modelo_media_rural']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_media_rural">
                                Media Rural
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_pensar_media" id="modelo_pensar_media" value="1" <?php if(isset($row['modelo_pensar_media']) && $row['modelo_pensar_media']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_pensar_media">
                                Modelo Pedagógico Pensar Media
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modelo_otro" id="modelo_otro" value="1" onchange="toggleModeloOtro()" <?php if(isset($row['modelo_otro']) && $row['modelo_otro']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="modelo_otro">
                                Otro
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" id="modelo_otro_cual_div" style="display: none;">
                    <div class="col-12 col-sm-6">
                        <label for="modelo_otro_cual">¿Cuál?:</label>
                        <input type="text" name="modelo_otro_cual" id="modelo_otro_cual" class="form-control" style="text-transform:uppercase;" value='<?php if(isset($row['modelo_otro_cual'])){echo $row['modelo_otro_cual'];} ?>' />
                    </div>
                </div>

                <!-- CAMPOS DINÁMICOS PARA MODELOS ADICIONALES -->
                <div class="row mt-3">
                    <div class="col-12">
                        <label><b>Modelos Adicionales:</b></label>
                        <p style="color: #666; font-size: 0.9em;">Agregue modelos educativos flexibles adicionales que no estén en la lista anterior</p>
                    </div>
                </div>
                <div id="modelos_adicionales_container">
                    <?php 
                    if(isset($row['modelos_flexibles_adicionales']) && !empty($row['modelos_flexibles_adicionales'])) {
                        $modelos = explode(',', $row['modelos_flexibles_adicionales']);
                        foreach($modelos as $index => $modelo) {
                            $modelo = trim($modelo);
                            echo "
                            <div class='row mb-2 modelo-adicional-row' id='modelo_adicional_row_$index'>
                                <div class='col-12 col-sm-10'>
                                    <input type='text' name='modelos_flexibles_adicionales[]' class='form-control' style='text-transform:uppercase;' value='$modelo' placeholder='Ingrese el nombre del modelo' />
                                </div>
                                <div class='col-12 col-sm-2'>
                                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarModeloAdicional(\"modelo_adicional_row_$index\")'>
                                        <i class='fas fa-trash'></i> Eliminar
                                    </button>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "
                        <div class='row mb-2 modelo-adicional-row' id='modelo_adicional_row_0'>
                            <div class='col-12 col-sm-10'>
                                <input type='text' name='modelos_flexibles_adicionales[]' class='form-control' style='text-transform:uppercase;' placeholder='Ingrese el nombre del modelo' />
                            </div>
                            <div class='col-12 col-sm-2'>
                                <button type='button' class='btn btn-danger btn-sm' onclick='eliminarModeloAdicional(\"modelo_adicional_row_0\")'>
                                    <i class='fas fa-trash'></i> Eliminar
                                </button>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-success btn-sm" onclick="agregarModeloAdicional()">
                            <i class="fas fa-plus"></i> Agregar otro modelo
                        </button>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <h4><b><CENTER>NIVELES QUE OFRECE</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">PREESCOLAR:</label>
                        <select class="form-control" name="niv_1_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_1_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_1_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">BÁSICA PRIMARIA:</label>
                        <select class="form-control" name="niv_2_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_2_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_2_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">BÁSICA SECUNDARIA:</label>
                        <select class="form-control" name="niv_3_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_3_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_3_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">MEDIA:</label>
                        <select class="form-control" name="niv_4_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_4_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_4_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN DE CICLOS -->
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">CICLOS:</label>
                        <select class="form-control" name="tiene_ciclos" id="tiene_ciclos" required onchange="toggleCiclos()">
                            <option value=""></option>   
                            <option value=1 <?php if(isset($row['tiene_ciclos']) && utf8_encode($row['tiene_ciclos'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(isset($row['tiene_ciclos']) && utf8_encode($row['tiene_ciclos'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- OPCIONES DE CICLOS (se muestra cuando tiene_ciclos = SI) -->
            <div class="form-group" id="opciones_ciclos" style="display: none;">
                <div class="row">
                    <div class="col-12">
                        <label><b>Tipo de Ciclos (seleccione uno o varios):</b></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_0" id="ciclo_0" value="1" <?php if(isset($row['ciclo_0']) && $row['ciclo_0']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_0">
                                Ciclo 0 (Preescolar Adultos)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_1" id="ciclo_1" value="1" <?php if(isset($row['ciclo_1']) && $row['ciclo_1']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_1">
                                Ciclo I (1°, 2° y 3°)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_2" id="ciclo_2" value="1" <?php if(isset($row['ciclo_2']) && $row['ciclo_2']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_2">
                                Ciclo II (4° y 5°)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_3" id="ciclo_3" value="1" <?php if(isset($row['ciclo_3']) && $row['ciclo_3']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_3">
                                Ciclo III (6° y 7°)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_4" id="ciclo_4" value="1" <?php if(isset($row['ciclo_4']) && $row['ciclo_4']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_4">
                                Ciclo IV (8° y 9°)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_5" id="ciclo_5" value="1" <?php if(isset($row['ciclo_5']) && $row['ciclo_5']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_5">
                                Ciclo V (10°)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ciclo_6" id="ciclo_6" value="1" <?php if(isset($row['ciclo_6']) && $row['ciclo_6']==1){echo 'checked';} ?>>
                            <label class="form-check-label" for="ciclo_6">
                                Ciclo VI (11°)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <h4><b><CENTER>CARACTER DE LA MEDIA</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label class="containerCheck">TÉCNICA:</label>
                        <select class="form-control" name="car_med_1_cole" id="car_med_1_cole" required onchange="toggleTecnica()">
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['car_med_1_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['car_med_1_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="containerCheck">ACADÉMICA:</label>
                        <select class="form-control" name="car_med_2_cole" id="car_med_2_cole" required onchange="toggleAcademica()">
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['car_med_2_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['car_med_2_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- CAMPOS DINÁMICOS PARA ESPECIALIDADES TÉCNICAS -->
            <div class="form-group" id="especialidades_tecnica_div" style="display: none;">
                <div class="row">
                    <div class="col-12">
                        <label><b>Especialidades de Media Técnica:</b></label>
                        <p style="color: #666; font-size: 0.9em;">Agregue una o más especialidades técnicas que ofrece la institución</p>
                    </div>
                </div>
                <div id="especialidades_tecnica_container">
                    <?php 
                    if(isset($row['especialidades_tecnica']) && !empty($row['especialidades_tecnica'])) {
                        $especialidades = explode(',', $row['especialidades_tecnica']);
                        foreach($especialidades as $index => $especialidad) {
                            $especialidad = trim($especialidad);
                            echo "
                            <div class='row mb-2 especialidad-tecnica-row' id='especialidad_tecnica_row_$index'>
                                <div class='col-12 col-sm-10'>
                                    <input type='text' name='especialidades_tecnica[]' class='form-control' style='text-transform:uppercase;' value='$especialidad' placeholder='Ingrese la especialidad técnica' />
                                </div>
                                <div class='col-12 col-sm-2'>
                                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarEspecialidadTecnica(\"especialidad_tecnica_row_$index\")'>
                                        <i class='fas fa-trash'></i> Eliminar
                                    </button>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "
                        <div class='row mb-2 especialidad-tecnica-row' id='especialidad_tecnica_row_0'>
                            <div class='col-12 col-sm-10'>
                                <input type='text' name='especialidades_tecnica[]' class='form-control' style='text-transform:uppercase;' placeholder='Ingrese la especialidad técnica' />
                            </div>
                            <div class='col-12 col-sm-2'>
                                <button type='button' class='btn btn-danger btn-sm' onclick='eliminarEspecialidadTecnica(\"especialidad_tecnica_row_0\")'>
                                    <i class='fas fa-trash'></i> Eliminar
                                </button>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-success btn-sm" onclick="agregarEspecialidadTecnica()">
                            <i class="fas fa-plus"></i> Agregar otra especialidad técnica
                        </button>
                    </div>
                </div>
            </div>

            <!-- CAMPOS DINÁMICOS PARA ESPECIALIDADES ACADÉMICAS -->
            <div class="form-group" id="especialidad_academica_div" style="display: none;">
                <div class="row">
                    <div class="col-12">
                        <label><b>Especialidades de Media Académica:</b></label>
                        <p style="color: #666; font-size: 0.9em;">Agregue una o más especialidades académicas que ofrece la institución</p>
                    </div>
                </div>
                <div id="especialidades_academica_container">
                    <?php 
                    if(isset($row['especialidad_academica']) && !empty($row['especialidad_academica'])) {
                        $especialidades_acad = explode(',', $row['especialidad_academica']);
                        foreach($especialidades_acad as $index => $especialidad) {
                            $especialidad = trim($especialidad);
                            echo "
                            <div class='row mb-2 especialidad-academica-row' id='especialidad_academica_row_$index'>
                                <div class='col-12 col-sm-10'>
                                    <input type='text' name='especialidad_academica[]' class='form-control' style='text-transform:uppercase;' value='$especialidad' placeholder='Ingrese la especialidad académica' />
                                </div>
                                <div class='col-12 col-sm-2'>
                                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarEspecialidadAcademica(\"especialidad_academica_row_$index\")'>
                                        <i class='fas fa-trash'></i> Eliminar
                                    </button>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "
                        <div class='row mb-2 especialidad-academica-row' id='especialidad_academica_row_0'>
                            <div class='col-12 col-sm-10'>
                                <input type='text' name='especialidad_academica[]' class='form-control' style='text-transform:uppercase;' placeholder='Ingrese la especialidad académica' />
                            </div>
                            <div class='col-12 col-sm-2'>
                                <button type='button' class='btn btn-danger btn-sm' onclick='eliminarEspecialidadAcademica(\"especialidad_academica_row_0\")'>
                                    <i class='fas fa-trash'></i> Eliminar
                                </button>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-success btn-sm" onclick="agregarEspecialidadAcademica()">
                            <i class="fas fa-plus"></i> Agregar otra especialidad académica
                        </button>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="corregimiento_cole">CORREGIMIENTO:</label>
                        <input type='text' name='corregimiento_cole' id="corregimiento_cole" class='form-control' style="text-transform:uppercase;" value='<?php echo $row['corregimiento_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="id_mun">* MUNICIPIO:</label>
                        <select name='id_mun' class='form-control' required />
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta='SELECT * FROM municipios';
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row1 = $res->fetch_array())
                                    {
                                    ?>
                            <option value='<?php echo $row1['id_mun']; ?>'<?php if($row['id_mun']==$row1['id_mun']){echo 'selected';} ?>>
                                <?php echo utf8_encode($row1['nombre_mun']); ?>
                            </option>
                                    <?php
                                    }
                                    ?>    
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="tel1_cole">* TELÉFONO DE CONTACTO:</label>
                        <input type='text' name='tel1_cole' class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['tel1_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="tel2_cole">OTRO TELÉFONO DE CONTACTO:</label>
                        <input type='text' name='tel2_cole' class='form-control' style="text-transform:uppercase;" value='<?php echo $row['tel2_cole']; ?>' />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <label for="email_cole">EMAIL:</label>
                        <input type='email' name='email_cole' class='form-control' value='<?php echo $row['email_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="num_act_adm_cole">* NÚMERO ACTO ADMINISTRATIVO:</label>
                        <input type='number' name='num_act_adm_cole' class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['num_act_adm_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="fec_res_cole">* FECHA RESOLUCIÓN:</label>
                        <input type='date' name='fec_res_cole' class='form-control' required value='<?php echo $row['fec_res_cole']; ?>' />
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <label for="obs_cole">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" name="obs_cole" style="text-transform:uppercase;" /><?php echo $row['obs_cole']; ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR RESOLUCIÓN VIGENTE:</label>
                        
                        <?php
                        // Mostrar archivos existentes
                        $nit_cole = $row['nit_cole'];
                        $cod_dane_cole = $row['cod_dane_cole'];
                        $directorio_archivos = 'files/' . $nit_cole;
                        
                        if(file_exists($directorio_archivos)) {
                            $archivos = array_diff(scandir($directorio_archivos), array('.', '..'));
                            
                            if(count($archivos) > 0) {
                                echo '<div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">';
                                echo '<p style="margin-bottom: 10px;"><strong>Archivos cargados:</strong></p>';
                                echo '<ul style="list-style: none; padding: 0;">';
                                
                                foreach($archivos as $archivo) {
                                    $ruta_descarga = 'files/' . $nit_cole . '/' . $archivo;
                                    echo '<li style="margin-bottom: 8px; padding: 8px; background-color: white; border-radius: 3px; display: flex; align-items: center; justify-content: space-between;">';
                                    echo '<span><i class="fas fa-file-pdf" style="color: #dc3545; margin-right: 8px;"></i>' . htmlspecialchars($archivo) . '</span>';
                                    echo '<div>';
                                    echo '<a href="' . $ruta_descarga . '" download class="btn btn-sm btn-success" style="margin-right: 5px;" title="Descargar"><i class="fas fa-download"></i> Descargar</a>';
                                    echo '<a href="eliminar_resolucion.php?archivo=' . urlencode($archivo) . '&nit_cole=' . urlencode($nit_cole) . '&cod_dane_cole=' . urlencode($cod_dane_cole) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Está seguro que desea eliminar este archivo?\');" title="Eliminar"><i class="fas fa-trash"></i> Eliminar</a>';
                                    echo '</div>';
                                    echo '</li>';
                                }
                                
                                echo '</ul>';
                                echo '</div>';
                            }
                        }
                        ?>
                        
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf">
                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                GUARDAR y/o ACTUALIZAR INFORMACIÓN 
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>

    <script>
        // Contador global para especialidades técnicas
        let contadorEspecialidadesTecnicas = <?php 
            if(isset($row['especialidades_tecnica']) && !empty($row['especialidades_tecnica'])) {
                echo count(explode(',', $row['especialidades_tecnica']));
            } else {
                echo "1";
            }
        ?>;

        // Contador global para modelos adicionales
        let contadorModelosAdicionales = <?php 
            if(isset($row['modelos_flexibles_adicionales']) && !empty($row['modelos_flexibles_adicionales'])) {
                echo count(explode(',', $row['modelos_flexibles_adicionales']));
            } else {
                echo "1";
            }
        ?>;

        // Contador global para especialidades académicas
        let contadorEspecialidadesAcademicas = <?php 
            if(isset($row['especialidad_academica']) && !empty($row['especialidad_academica'])) {
                echo count(explode(',', $row['especialidad_academica']));
            } else {
                echo "1";
            }
        ?>;

        // Función para mostrar/ocultar opciones de ciclos
        function toggleCiclos() {
            const tieneCiclos = document.getElementById('tiene_ciclos').value;
            const opcionesCiclos = document.getElementById('opciones_ciclos');
            
            if (tieneCiclos == '1') {
                opcionesCiclos.style.display = 'block';
            } else {
                opcionesCiclos.style.display = 'none';
                // Desmarcar todos los checkboxes de ciclos
                document.querySelectorAll('[id^="ciclo_"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
        }

        // Función para mostrar/ocultar campo "Otro modelo"
        function toggleModeloOtro() {
            const modeloOtro = document.getElementById('modelo_otro').checked;
            const modeloOtroCualDiv = document.getElementById('modelo_otro_cual_div');
            
            if (modeloOtro) {
                modeloOtroCualDiv.style.display = 'block';
            } else {
                modeloOtroCualDiv.style.display = 'none';
                document.getElementById('modelo_otro_cual').value = '';
            }
        }

        // Función para mostrar/ocultar especialidades técnicas
        function toggleTecnica() {
            const tecnica = document.getElementById('car_med_1_cole').value;
            const especialidadesTecnicaDiv = document.getElementById('especialidades_tecnica_div');
            
            if (tecnica == '1') {
                especialidadesTecnicaDiv.style.display = 'block';
            } else {
                especialidadesTecnicaDiv.style.display = 'none';
            }
        }

        // Función para mostrar/ocultar especialidad académica
        function toggleAcademica() {
            const academica = document.getElementById('car_med_2_cole').value;
            const especialidadAcademicaDiv = document.getElementById('especialidad_academica_div');
            
            if (academica == '1') {
                especialidadAcademicaDiv.style.display = 'block';
            } else {
                especialidadAcademicaDiv.style.display = 'none';
                document.getElementById('especialidad_academica').value = '';
            }
        }

        // Función para agregar una nueva especialidad técnica
        function agregarEspecialidadTecnica() {
            const container = document.getElementById('especialidades_tecnica_container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 especialidad-tecnica-row';
            newRow.id = 'especialidad_tecnica_row_' + contadorEspecialidadesTecnicas;
            
            newRow.innerHTML = `
                <div class='col-12 col-sm-10'>
                    <input type='text' name='especialidades_tecnica[]' class='form-control' style='text-transform:uppercase;' placeholder='Ingrese la especialidad técnica' />
                </div>
                <div class='col-12 col-sm-2'>
                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarEspecialidadTecnica("especialidad_tecnica_row_${contadorEspecialidadesTecnicas}")'>
                        <i class='fas fa-trash'></i> Eliminar
                    </button>
                </div>
            `;
            
            container.appendChild(newRow);
            contadorEspecialidadesTecnicas++;
        }

        // Función para eliminar una especialidad técnica
        function eliminarEspecialidadTecnica(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                // Verificar que no sea la única fila
                const totalRows = document.querySelectorAll('.especialidad-tecnica-row').length;
                if (totalRows > 1) {
                    row.remove();
                } else {
                    alert('Debe mantener al menos una especialidad técnica');
                }
            }
        }

        // Función para agregar un nuevo modelo adicional
        function agregarModeloAdicional() {
            const container = document.getElementById('modelos_adicionales_container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 modelo-adicional-row';
            newRow.id = 'modelo_adicional_row_' + contadorModelosAdicionales;
            
            newRow.innerHTML = `
                <div class='col-12 col-sm-10'>
                    <input type='text' name='modelos_flexibles_adicionales[]' class='form-control' style='text-transform:uppercase;' placeholder='Ingrese el nombre del modelo' />
                </div>
                <div class='col-12 col-sm-2'>
                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarModeloAdicional("modelo_adicional_row_${contadorModelosAdicionales}")'>
                        <i class='fas fa-trash'></i> Eliminar
                    </button>
                </div>
            `;
            
            container.appendChild(newRow);
            contadorModelosAdicionales++;
        }

        // Función para eliminar un modelo adicional
        function eliminarModeloAdicional(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                // Verificar que no sea la única fila
                const totalRows = document.querySelectorAll('.modelo-adicional-row').length;
                if (totalRows > 1) {
                    row.remove();
                } else {
                    // Si es la única fila, solo limpiar el input
                    const input = row.querySelector('input');
                    if (input) {
                        input.value = '';
                    }
                }
            }
        }

        // Función para agregar una nueva especialidad académica
        function agregarEspecialidadAcademica() {
            const container = document.getElementById('especialidades_academica_container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 especialidad-academica-row';
            newRow.id = 'especialidad_academica_row_' + contadorEspecialidadesAcademicas;
            
            newRow.innerHTML = `
                <div class='col-12 col-sm-10'>
                    <input type='text' name='especialidad_academica[]' class='form-control' style='text-transform:uppercase;' placeholder='Ingrese la especialidad académica' />
                </div>
                <div class='col-12 col-sm-2'>
                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarEspecialidadAcademica("especialidad_academica_row_${contadorEspecialidadesAcademicas}")'>
                        <i class='fas fa-trash'></i> Eliminar
                    </button>
                </div>
            `;
            
            container.appendChild(newRow);
            contadorEspecialidadesAcademicas++;
        }

        // Función para eliminar una especialidad académica
        function eliminarEspecialidadAcademica(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                // Verificar que no sea la única fila
                const totalRows = document.querySelectorAll('.especialidad-academica-row').length;
                if (totalRows > 1) {
                    row.remove();
                } else {
                    alert('Debe mantener al menos una especialidad académica');
                }
            }
        }

        // Ejecutar al cargar la página para mostrar campos según valores guardados
        document.addEventListener('DOMContentLoaded', function() {
            toggleCiclos();
            toggleModeloOtro();
            toggleTecnica();
            toggleAcademica();
        });
    </script>
</body>
</html>