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
	include("../../conexion.php");
	require_once("../../zebra.php");

?>

		<div class="container">
			<h1><b><i class="fas fa-chalkboard-teacher"></i> REGISTRO DE MISIÓN, VISIÓN, PERFIL DEL EGRESADO y OBJETIVOS INSTITUCIONALES</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addteleologico2.php' enctype="multipart/form-data" method="POST">
				
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
                    	<div class="col">
	                        <label for="mision_ct">MISIÓN: (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="10" cols="55" name="mision_ct" maxlength="9000" style="text-transform:uppercase;" /></textarea>
                    	</div>
                    	<div class="col">
                        	<label for="vision_ct">VISIÓN: (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="10" cols="55" name="vision_ct" maxlength="9000" style="text-transform:uppercase;" /></textarea>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col">
	                        <label for="per_egr_ct">PERFIL DEL EGRESADO: (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="10" cols="55" name="per_egr_ct" maxlength="9000" style="text-transform:uppercase;" /></textarea>
                    	</div>
                    	<div class="col">
                        	<label for="obj_ins_ct">OBJETIVOS INSTITUCIONALES: (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="10" cols="55" name="obj_ins_ct" maxlength="9000" style="text-transform:uppercase;" /></textarea>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_ct">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
	                        <textarea class="form-control" rows="5" name="obs_ct" style="text-transform:uppercase;" /></textarea>
                    	</div>
	                </div>
            	</div>
 
                <div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR SOPORTE y/o ARCHIVO QUE CONTIENE EL COMPONENTE TELEOLÓGICO:</label>
	                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*">
	                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
	                    </div>
                	</div>
            	</div>
				
				<button type="submit" class="btn btn-primary">
					<span class="spinner-border spinner-border-sm"></span>
					GUARDAR y/o ALMACENAR DATOS
				</button>
				<button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
				</button>
			</form>
		</div>

	</body>
</html>