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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PEI | SOFT</title>
        <link rel="stylesheet" href="../../../css/bootstrap.min.css">
        <script type="text/javascript" src="../../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../../js/popper.min.j"></script>
        <script type="text/javascript" src="../../../js/bootstrap.min.js"></script>
        <link href="../../../fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
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
	    	<img src="../../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
		</center>
		<br />
<?php

	date_default_timezone_set("America/Bogota");
	include("../../../conexion.php");
	require_once("../../../zebra.php");

?>

		<div class="container">
			<h1><b><i class="fas fa-baby"></i> CAPÍTULO EDUCACIÓN INICIAL</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addeduca2.php' enctype="multipart/form-data" method="POST">
				
				<div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <p style="font-family: 'Rajdhani', sans-serif; color: #000000; text-align: justify;">Fundamentado según la normatividad para Educación Inicial y Preescolar: <I>Convención Internacional de los derechos del Niño -Ley 12 de 1991-, Constitución Política de Colombia Art. 44, Ley General de Educación, Ley 115 de 1994, Decreto 1860 de 1994 - Reglamenta la Ley 115, Decreto 2247 de 1997 tener en cuenta el artículo 10, Código de Infancia y Adolescencia, Ley 1098 de 2006, Política Pública Nacional de Primera Infancia-Conpes 109 de 2007, Ley 1804 de 2016, De cero a siempre artículo 5, Ley 2025 de 2020 y los Referentes Técnicos para Educación Inicial</I> (Derechos Básicos de Aprendizaje, Actividades Rectoras, Tránsito Armónico, Lectura y Escritura Emergente, Seguimiento al Desarrollo Integral, Bases Curriculares)<BR><br>
	                        <B>Se procede a cargar el o los documentos relacionados (PDF o Word).</B></p>

	                    </div>
                	</div>
            	</div>

            	<div class="form-group">
                	<div class="row">
                		<label for="id_cole">NOMBRE DEL ESTABLECIMIENTO EDUCATIVO (verifique que muestre de forma correcta el nombre de su establecimiento educativo):</label>
	                        <select name='id_cole' class='form-control' disabled/>
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
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_edu_ini">OBSERVACIONES y/o COMENTARIOS ADICIONALES (número de caracteres permitido-> <span></span>)</label></label>
	                        <textarea class="form-control" rows="7" cols="124" name="obs_edu_ini" maxlength="10000" style="text-transform:uppercase;" ></textarea>
                		</div>
	                </div>
            	</div>

                <div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR EL o LOS DOCUMENTOS SOBRE <u>EL CAPÍTULO INICIAL</u>:</label>
	                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/msexcel, application/msword, application/pdf, application/rtf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*">
	                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Trate de utilizar archivos de tipo: <B><U>PDF,</U></B> pero de igual manera le permite EXCEL, WORD, POWERPOINT e IMÁGENES </p>
	                    </div>
                	</div>
            	</div>
				
				<button type="submit" class="btn btn-primary">
					<span class="spinner-border spinner-border-sm"></span>
					GUARDAR y/o ALMACENAR DATOS CAPÍTULO INICIAL
				</button>
				<button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../../img/atras.png' width=27 height=27> REGRESAR
				</button>
			</form>
		</div>

	</body>
</html>