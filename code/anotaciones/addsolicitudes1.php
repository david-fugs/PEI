<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre 		= $_SESSION['nombre'];
    $tipo_usuario 	= $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PEI | SOFT</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script type="text/javascript" src="../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/popper.min.j"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <link href="../../fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
    	</style>
  		<script>
		    var inputs = "input[maxlength], textarea[maxlength]";
		    $(document).on('keyup', "[maxlength]", function (e) {
		    var este = $(this),
		      maxlength = este.attr('maxlength'),
		      maxlengthint = parseInt(maxlength),
		      textoActual = este.val(),
		      currentCharacters = este.val().length;
		      remainingCharacters = maxlengthint - currentCharacters,
		      espan = este.prev('label').find('span');      
		      // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
		      if (document.addEventListener && !window.requestAnimationFrame) {
		        if (remainingCharacters <= -1) {
		          remainingCharacters = 0;            
		        }
		      }
		      espan.html(remainingCharacters);
		      if (!!maxlength) {
		        var texto = este.val(); 
		        if (texto.length >= maxlength) {
		          este.removeClass().addClass("borderojo");
		          este.val(text.substring(0, maxlength));
		          e.preventDefault();
		        }
		        else if (texto.length < maxlength) {
		          este.removeClass().addClass("bordegris");
		        } 
		      } 
		    });
		</script>
		<script>
	        function ordenarSelect(id_componente)
	          {
	            var selectToSort = jQuery('#' + id_componente);
	            var optionActual = selectToSort.val();
	            selectToSort.html(selectToSort.children('option').sort(function (a, b) {
	              return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
	            })).val(optionActual);
	          }
	          $(document).ready(function () {
	            ordenarSelect('selectIE');
	          });
	    </script>
    <head>
    <body>
  
		<center>
	    	<img src="../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
		</center>
		<br />
<?php

	date_default_timezone_set("America/Bogota");
	$fecha = date("Y-m-d");
	include("../../conexion.php");
	require_once("../../zebra.php");

?>

		<div class="container">
			<h1><b><i class="fas fa-bell-on"></i> GENERAR SOLICITUD DE ATENCIÓN y/o ASISTENCIA TÉCNICA A LA "SED"</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addsolicitudes2.php' enctype="multipart/form-data" method="POST">
				
				<div class="form-group">
                	<div class="row">
                		<label for="id_cole">NOMBRE DEL ESTABLECIMIENTO EDUCATIVO (verifique que muestre de forma correcta el nombre de su establecimiento educativo):</label>
	                        <select name='id_cole' class='form-control' readonly />
		                        <option value=''></option>
		                            <?php
		                                header('Content-Type: text/html;charset=utf-8');
		                                $consulta='SELECT * FROM colegios';
		                                $res = mysqli_query($mysqli,$consulta);
		                                $num_reg = mysqli_num_rows($res);
		                                while($row1 = $res->fetch_array())
		                                {
		                                ?>
		                        <option value='<?php echo $row1['id_cole']; ?>'<?php if($id_cole==$row1['id_cole']){echo 'selected';} ?>>
		                            <?php echo utf8_encode($row1['nombre_cole']); ?>
		                        </option>
		                                <?php
		                                }
		                                ?>    
                        	</select>
                	</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-3">
	                        <label for="fecha_sol">* FECHA ANOTACIÓN:</label>
                        	<input type='date' name='fecha_sol' value='<?php echo $fecha;?>' class='form-control' readonly />
                    	</div>
                    	<div class="col-12 col-sm-5">
	                        <label for="tipo_sol">* SELECCIONE EL TIPO DE SOLICITUD:</label>
	                        <select class="form-control" name="tipo_sol" required>
					            <option value=""></option>
					            <option value="ASISTENCIA TÉCNICA">ASISTENCIA TÉCNICA</option>
					            <option value="CAPACTACIÓN">CAPACTACIÓN</option> 
					            <option value="SOPORTE TÉCNICO">SOPORTE TÉCNICO</option>
					            <option value="OTRO">OTRO</option> 
					        </select>
                    	</div>
                   	</div>
                </div>

                <div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_sol">ESPECIFIQUE LA SOLICITUD y/o REQUERMIENTO QUE DESEA GENERAR A LA "SED":</label>
	                        <textarea class="form-control" rows="15" name="obs_sol" /></textarea>
                    	</div>
	                </div>
            	</div>
 
				<button type="submit" class="btn btn-primary">
					<span class="spinner-border spinner-border-sm"></span>
					GUARDAR y/o ALMACENAR DATOS
				</button>
				<button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=50 height=50> REGRESAR
				</button>
			</form>
		</div>

	</body>
</html>