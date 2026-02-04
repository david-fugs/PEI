<?php
    
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
			<h1><b><i class="fas fa-user-check"></i> SISTEMA INSTITUCIONAL DE EVALUACIÓN DE LOS ESTUDIANTES -SIEE-</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='siee2.php' enctype="multipart/form-data" method="POST">
				
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
                    	<div class="col-12 col-sm-4">
	                        <label for="preg1_siee">* 1. ¿Tiene definido el sistema institucional de evaluación de los estudiantes en su establecimiento educativo?</label>
	                        <select class="form-control" name="preg1_siee" required>
					            <option value=""></option>
					            <option value="SI">SI</option>
					            <option value="NO">NO</option> 
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-4">
                        	<label for="preg2_siee">* 2. ¿El sistema institucional de evaluación se encuentra aprobado y adoptado por el Consejo Acádemico y el Consejo Directivo?</label>
	                        <select class="form-control" name="preg2_siee" required>
      					            <option value=""></option>
      					            <option value="SI">SI</option>
      					            <option value="NO">NO</option> 
      					        </select>
                   		</div>
                      <div class="col-12 col-sm-4">
                          <label for="preg3_siee">* 3. ¿La adopción del SIEE esta oficializada mediante acto administrativo?</label>
                          <select class="form-control" name="preg3_siee" required>
                            <option value=""></option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option> 
                        </select>
                      </div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-4">
                          <label for="preg3_1_siee">3.1. Si la pregunta anterior (3) fue respondida de forma afirmativa "SI", responda: Acto Administrativo No.</label>
                          <input type='number' name='preg3_1_siee' class='form-control' />
                      </div>
                      <div class="col-12 col-sm-4">
                          <label for="preg3_2_siee">3.2. Si la pregunta anterior (3) fue respondida de forma afirmativa "SI", responda: Fecha Acto Administrativo:</label>
                          <input type='date' name='preg3_2_siee' class='form-control' />
                      </div>
                      <!-- lOS CAMPOS preg4_siee Y preg5_siee SE INVIRTIERON EN LAS PREGUNTAS, PORQUE SE ELIMINÓ UN CAMPO Y POR ORGANIZACIÓN DEL FORMULARIO-->
                      <div class="col-12 col-sm-4">
                          <label for="preg5_siee">* 4. ¿El SIEE fue publicado y socializado mediante acto administrativo a la comunidad educativa?</label>
                          <select class="form-control" name="preg5_siee" required>
                            <option value=""></option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option> 
                        </select>
                      </div>
                   	</div>
                </div>
                <!-- lOS CAMPOS preg4_siee Y preg5_siee SE INVIRTIERON EN LAS PREGUNTAS, PORQUE SE ELIMINÓ UN CAMPO Y POR ORGANIZACIÓN DEL FORMULARIO-->
                <div class="form-group">
                	<div class="row">   		
                      <div class="col-12">
                          <label for="preg4_siee">* 5. Indicar ¿cómo se ha incorporado en el proyecto educativo institucional los criterios, procesos y procedimientos de evaluación; estrategias para la superación de debilidades y promoción de los estudiantes, definidos por el consejo directivo?</label>
                          <textarea class="form-control" rows="3" name="preg4_siee" required style="text-transform:uppercase;" /></textarea>
                      </div>
               		</div>
                </div>

              <hr style="border: 4px solid #04547c; border-radius: 5px;">
	            <h5><b><CENTER>6. Relacione la escala de valoración que se tiene para cada uno de los niveles y ciclos educativos que se manejan en el Establecimiento Educativo y los Modelos Educativos Flexibles que se tengan.</h5></CENTER></b>

	            <div class="form-group">
                	<div class="row">   		
                   		<div class="col-12 col-sm-6">
                        	<label for="preg6_1_siee">Preescolar (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="7" cols="57" name="preg6_1_siee" maxlength="5000" style="text-transform:uppercase;" /></textarea>
                   		</div>
                   		<div class="col-12 col-sm-6">
                        	<label for="preg6_2_siee">Primaria (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="7" cols="57" name="preg6_2_siee" maxlength="5000" style="text-transform:uppercase;" /></textarea>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">   		
                   		<div class="col-12 col-sm-6">
                        	<label for="preg6_3_siee">Secundaria (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="7" cols="57" name="preg6_3_siee" maxlength="5000" style="text-transform:uppercase;" /></textarea>
                   		</div>
                   		<div class="col-12 col-sm-6">
                        	<label for="preg6_4_siee">Media (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="7" cols="57" name="preg6_4_siee" maxlength="5000" style="text-transform:uppercase;" /></textarea>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">   		
                   		<div class="col-12 col-sm-6">
                        	<label for="preg6_5_siee">Modelos Educativos Flexibles: (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="7" cols="57" name="preg6_5_siee" maxlength="5000" style="text-transform:uppercase;" /></textarea>
                   		</div>
                   		<div class="col-12 col-sm-6">
                        	<label for="preg7_siee">* 7. Enunciar los criterios que se tienen para la promoción anticipada</label>
	                        <textarea class="form-control" rows="7" name="preg7_siee" required style="text-transform:uppercase;" /></textarea>
                   		</div>
               		</div>
                </div>
                <hr style="border: 4px solid #04547c; border-radius: 5px;">

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="preg8_siee">* 8. Señale qué clase de evaluación se maneja en el EE:</label>
	                        <select class="form-control" name="preg8_siee" required>
					            <option value=""></option>
					            <option value="EVALUACION FORMATIVA">EVALUACION FORMATIVA</option>
					            <option value="AUTOEVALUACION">AUTOEVALUACION</option> 
					            <option value="COEVALUACION">COEVALUACION</option> 
					            <option value="HETEROEVALUACION">HETEROEVALUACION</option> 
					            <option value="TODAS LAS ANTERIORES">TODAS LAS ANTERIORES</option> 
					            <option value="OTRA">OTRA</option> 
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="preg8_1_siee">8.1. Si la pregunta anterior (8) fue respondida con la opción "Otra", responda: ¿Cuál?:</label>
	                        <input type='text' name='preg8_1_siee' class='form-control' style="text-transform:uppercase;" />
                   		</div>
                   	</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="preg9_siee">* 9. Se tienen definidos instrumentos para el seguimiento de los aprendizajes que permitan generar informes parciales para el conocimiento de los padres de familia o acudientes?</label>
	                        <select class="form-control" name="preg9_siee" required>
					            <option value=""></option>
					            <option value="SI">SI</option>
					            <option value="NO">NO</option> 
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="preg9_1_siee">9.1. Si la pregunta anterior (9) fue respondida de forma afirmativa "SI", indique ¿Cuáles?:</label>
	                        <textarea class="form-control" rows="2" name="preg9_1_siee" style="text-transform:uppercase;" /></textarea>
                   		</div>
                   	</div>
                </div>
 
                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="preg10_siee">* 10. Se cuenta con un monitoreo y seguimiento a los avances de los estudiantes para cada uno de los criterios de evaluación.</label>
	                        <select class="form-control" name="preg10_siee" required>
					            <option value=""></option>
					            <option value="SI">SI</option>
					            <option value="NO">NO</option> 
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="preg10_1_siee">10.1. Si la pregunta anterior (10) fue respondida de forma afirmativa "SI", por favor enunciarlos:</label>
	                        <textarea class="form-control" rows="2" name="preg10_1_siee" style="text-transform:uppercase;" /></textarea>
                   		</div>
                   	</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="preg11_siee">* 11. Señale con que periodicidad se rinde los informes de calificaciones, notas o desempeños de los estudiantes durante el año escolar:</label>
	                        <select class="form-control" name="preg11_siee" required>
					            <option value=""></option>
					            <option value="BIMESTRAL">BIMESTRAL</option>
					            <option value="TRIMESTRAL">TRIMESTRAL</option> 
					            <option value="CUATRIMESTRAL">CUATRIMESTRAL</option> 
					            <option value="SEMESTRAL">SEMESTRAL</option> 
					            <option value="OTRA">OTRA</option>  
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="preg11_1_siee">11.1. Si la pregunta anterior (11) fue respondida con la opción "Otra", responda: ¿Cuál?:</label>
	                        <input type='text' name='preg11_1_siee' class='form-control' style="text-transform:uppercase;" />
                   		</div>
                   	</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="preg12_siee">* 12. ¿El sistema institucional de evaluación fue divulgado a los estudiantes y la comunidad educativa?</label>
	                        <select class="form-control" name="preg12_siee" required>
					            <option value=""></option>
					            <option value="SI">SI</option>
					            <option value="NO">NO</option> 
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="preg12_1_siee">12.1. Si la pregunta anterior (12) fue respondida de forma afirmativa "SI", responda: ¿Cómo se realizó?:</label>
	                        <textarea class="form-control" rows="2" name="preg12_1_siee" style="text-transform:uppercase;" /></textarea>
                   		</div>
                   	</div>
                </div>

                <div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_siee">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
	                        <textarea class="form-control" rows="5" name="obs_siee" style="text-transform:uppercase;" /></textarea>
                    	</div>
	                </div>
            	</div>

            	<div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR ACTOS, ACTO ADMINISTRATIVO y/o EVIDENCIAS</label>
	                         <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="*.*" required >
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