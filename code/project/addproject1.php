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
        function ordenarSelect(id_componente)
          {
            var selectToSort = jQuery('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function (a, b) {
              return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
          }
          $(document).ready(function () {
            ordenarSelect('selectProy');
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
	    	<img src='../../img/logo_educacion_fondo_azul.png' width="600" height="111" class="responsive">
		</center>
		<br />
<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

?>

		<div class="container">
			<h1><b><i class="fas fa-project-diagram"></i>REGISTRO PROYECTOS TRANSVERSALES</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addproject2.php' enctype="multipart/form-data" method="POST">
				
				<div class="form-group">
                	<div class="row">
                		<label for="id_cole">NOMBRE DEL ESTABLECIMIENTO EDUCATIVO (verifique que muestre de forma correcta el nombre de su establecimiento educativo):</label>
	                        <select name='id_cole' class='form-control' disabled />
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
                    	<div class="col-12 col-sm-6">
	                        <label for="nombre_proy_trans">* NOMBRE DEL PROYECTO:</label>
                        	<select class="form-control" name="nombre_proy_trans" required id="selectProy">
					            <option value=""></option>					            
					            <option value="EDUCACION Y SEGURIDAD VIAL PESV">EDUCACION Y SEGURIDAD VIAL PESV</option>					            
					            <option value="EDUCACION ECONOMICA Y FINANCIERA">EDUCACION ECONOMICA Y FINANCIERA</option>
					            <option value="ESTILOS DE VIDA SALUDABLE EVS">ESTILOS DE VIDA SALUDABLE EVS</option>
					            <option value="EDUDERECHOS DDHH">EDUDERECHOS DDHH</option>
					            <option value="CATEDRA DE LA PAZ">CATEDRA DE LA PAZ</option>
					            <option value="GESTION DE RIESGO EN INSTITUCIONES EDUCATIVAS">GESTION DE RIESGO EN INSTITUCIONES EDUCATIVAS</option>
					            <option value="USO CREATIVO Y APROVECHAMIENTO DEL TIEMPO LIBRE">USO CREATIVO Y APROVECHAMIENTO DEL TIEMPO LIBRE</option>
					            <option value="PROYECTO DE DEMOCRACIA Y DERECHOS HUMANOS">PROYECTO DE DEMOCRACIA Y DERECHOS HUMANOS</option>
					            <option value="PLAN DE GESTION DE RIESGOS">PLAN DE GESTION DE RIESGOS</option>
					            <option value="ESCUELA DE FAMILIAS">ESCUELA DE FAMILIAS</option>
					            <option value="OTRO">OTRO</option>
					        </select>
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="tipo_proy_trans">* TIPO DE PROYECTO:</label>
	                        <select class="form-control" name="tipo_proy_trans" required>
					            <option value=""></option>
					            <option value="TRANSVERSAL OBLIGATORIO">TRANSVERSAL OBLIGATORIO</option>
					            <option value="AULA O PEDAGOGICO">AULA o PEDAGOGICO</option>
					            <option value="PRODUCTIVO">PRODUCTIVO</option>
					            <option value="OTROS">OTROS</option>
					        </select>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12">
                        	<label for="nombre_tipo_proy_trans">Si se contestó "OTROS" en la anterior selección, por favor escriba el tipo de proyecto en este recuadro:</label>
	                        <input type='text' name='nombre_tipo_proy_trans' class='form-control' style="text-transform:uppercase;" />
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12">
                        	<label for="obj_proy_trans">* OBJETIVOS DEL PROYECTO: (número de caracteres permitido-> <span></span>)</label>
                        	<textarea class="form-control" rows="7" name="obj_proy_trans" style="text-transform:uppercase;" required cols="123" maxlength="10000"></textarea>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12">
                        	<label for="sos_proy_trans">SOSTENIBILIDAD DEL PROYECTO (Si con el tiempo se puede seguir realizando las actividades asociadas del proyecto)<br>(número de caracteres permitido-> <span></span>)</label>
                        	<textarea class="form-control" rows="3" name="sos_proy_trans" style="text-transform:uppercase;" cols="123" maxlength="10000"></textarea>
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12">
                        	<label for="des_proy_trans">* DESCRIPCIÓN DEL PROYECTO (Describa de forma clara el proyecto)<br>(número de caracteres permitido-> <span></span>)</label>
                        	<textarea class="form-control" rows="7" name="des_proy_trans" style="text-transform:uppercase;" required cols="123" maxlength="10000"></textarea>
                   		</div>
               		</div>
                </div>

                <hr style="border: 4px solid #04547c; border-radius: 5px;">
	            <h4><b><CENTER>POBLACIÓN IMPACTADA</h4></CENTER></b>
	            <label>Indicar si el proyecto se aplica en algunos grados o es un proyecto transversal de grado 0 a 11, por favor marque los grados donde aplica este proyecto</label>
                <div class="form-group">
	                <div class="row">
			            <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 0:</label>
					        <input type="hidden" name="gra_0_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_0_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
				        <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 1º:</label>
					        <input type="hidden" name="gra_1_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_1_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 2º:</label>
					        <input type="hidden" name="gra_2_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_2_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 3º:</label>
					        <input type="hidden" name="gra_3_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_3_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 4º:</label>
					        <input type="hidden" name="gra_4_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_4_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 5º:</label>
					        <input type="hidden" name="gra_5_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_5_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 6º:</label>
					        <input type="hidden" name="gra_6_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_6_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
				        <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 7º:</label>
					        <input type="hidden" name="gra_7_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_7_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 8º:</label>
					        <input type="hidden" name="gra_8_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_8_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 9º:</label>
					        <input type="hidden" name="gra_9_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_9_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 10º:</label>
					        <input type="hidden" name="gra_10_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_10_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
					    <div class="col-12 col-sm-2">
					        <label class="containerCheck">GRADO 11º:</label>
					        <input type="hidden" name="gra_11_proy_trans" value="NO">  
					        <input type="checkbox" name="gra_11_proy_trans" value="SI">
					        <span class="checkmark"></span>
					        </label>
				        </div>
	                </div>
	            </div>
	            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            	<div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_proy_trans">OBSERVACIONES y/o COMENTARIOS ADICIONALES: (número de caracteres permitido-> <span></span>)</label>
	                        <textarea class="form-control" rows="7" cols="122" maxlength="10000" name="obs_proy_trans" style="text-transform:uppercase;" ></textarea>
                    	</div>
	                </div>
            	</div>
            	
            	<div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR DOCUMENTOS RELACIONADOS CON EL PROYECTO TRANSVERSAL:</label>
	                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/msexcel, application/msword, application/pdf, application/rtf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*">
	                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;">Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
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