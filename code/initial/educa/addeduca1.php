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
        <script type="text/javascript" src="../../../js/popper.min.js"></script>
        <script type="text/javascript" src="../../../js/bootstrap.min.js"></script>
        <link href="../../../fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
        	.main-container {
        		background: #f8f9fa;
        		border-radius: 15px;
        		padding: 30px;
        		margin-top: 20px;
        		box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        	}
        	.form-header {
        		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        		color: white;
        		padding: 20px;
        		border-radius: 10px;
        		margin-bottom: 25px;
        		text-align: center;
        	}
        	.form-group {
        		margin-bottom: 20px;
        	}
        	.form-control {
        		border-radius: 8px;
        		border: 2px solid #e9ecef;
        		padding: 12px;
        		transition: all 0.3s ease;
        	}
        	.form-control.select-ie {
        		height: 60px;
        		padding: 15px;
        		font-size: 16px;
        		line-height: 1.5;
        		min-height: 60px;
        	}
        	.form-control:focus {
        		border-color: #667eea;
        		box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        	}
        	.btn-primary {
        		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        		border: none;
        		border-radius: 8px;
        		padding: 12px 30px;
        		font-weight: bold;
        		transition: all 0.3s ease;
        	}
        	.btn-primary:hover {
        		transform: translateY(-2px);
        		box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        	}
        	.btn-outline-dark {
        		border-radius: 8px;
        		padding: 12px 30px;
        		font-weight: bold;
        		transition: all 0.3s ease;
        	}
        	.btn-outline-dark:hover {
        		transform: translateY(-2px);
        	}
        	.file-input-container {
        		border: 2px dashed #ddd;
        		border-radius: 8px;
        		padding: 20px;
        		text-align: center;
        		transition: all 0.3s ease;
        	}
        	.file-input-container:hover {
        		border-color: #667eea;
        		background-color: #f8f9ff;
        	}
        	.file-input-container input[type="file"] {
        		border: 1px solid #ddd;
        		border-radius: 5px;
        		padding: 8px;
        		background: white;
        		min-height: auto !important;
        		height: auto !important;
        		width: 100%;
        		max-width: 100%;
        	}
        	.required-text {
        		color: #c68615;
        		font-weight: bold;
        		margin-bottom: 20px;
        	}
        	.info-text {
        		background: #e3f2fd;
        		border-left: 4px solid #2196f3;
        		padding: 15px;
        		border-radius: 5px;
        		margin-bottom: 20px;
        	}
        	.observaciones-textarea {
        		width: 100%;
        		border: 1px solid #ccc;
        		border-radius: 4px;
        		padding: 10px;
        		font-size: 14px;
        		min-height: 80px;
        		box-sizing: border-box;
        		resize: vertical;
        	}
    	</style>
  		<script>
		    // JavaScript eliminado para evitar conflictos con el input de observaciones
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
	            
	            // Confirmacion con SweetAlert
	            $('#educaForm').on('submit', function(e) {
	                e.preventDefault();
	                
	                Swal.fire({
	                    title: '¿Esta seguro?',
	                    text: "Se guardara el Capitulo de Educacion Inicial con la informacion proporcionada",
	                    icon: 'question',
	                    showCancelButton: true,
	                    confirmButtonColor: '#667eea',
	                    cancelButtonColor: '#d33',
	                    confirmButtonText: 'Si, guardar',
	                    cancelButtonText: 'Cancelar'
	                }).then((result) => {
	                    if (result.isConfirmed) {
	                        // Mostrar loader
	                        Swal.fire({
	                            title: 'Guardando...',
	                            text: 'Por favor espere mientras se procesan los datos',
	                            icon: 'info',
	                            allowOutsideClick: false,
	                            didOpen: () => {
	                                Swal.showLoading();
	                            }
	                        });
	                        
	                        // Enviar el formulario
	                        this.submit();
	                    }
	                });
	            });
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
			<div class="main-container">
				<div class="form-header">
					<h1><i class="fas fa-baby"></i> CAPITULO EDUCACION INICIAL</h1>
				</div>
				
				<div class="required-text">
					<i class="fas fa-asterisk"></i> Datos obligatorios
				</div>

				<form id="educaForm" action='addeduca2.php' enctype="multipart/form-data" method="POST">
					
					<div class="info-text">
						<i class="fas fa-info-circle"></i>
						<strong>Informacion:</strong> Fundamentado segun la normatividad para Educacion Inicial y Preescolar: <em>Convencion Internacional de los derechos del Nino -Ley 12 de 1991-, Constitucion Politica de Colombia Art. 44, Ley General de Educacion, Ley 115 de 1994, Decreto 1860 de 1994 - Reglamenta la Ley 115, Decreto 2247 de 1997 tener en cuenta el articulo 10, Codigo de Infancia y Adolescencia, Ley 1098 de 2006, Politica Publica Nacional de Primera Infancia-Conpes 109 de 2007, Ley 1804 de 2016, De cero a siempre articulo 5, Ley 2025 de 2020 y los Referentes Tecnicos para Educacion Inicial</em> (Derechos Basicos de Aprendizaje, Actividades Rectoras, Transito Armonico, Lectura y Escritura Emergente, Seguimiento al Desarrollo Integral, Bases Curriculares)<br><br>
						<strong>Se procede a cargar el o los documentos relacionados (PDF o Word).</strong>
					</div>

					<div class="form-group">
						<label for="id_cole"><i class="fas fa-school"></i> <strong>NOMBRE DEL ESTABLECIMIENTO EDUCATIVO:</strong></label>
						<small class="text-muted d-block mb-2">Verifique que muestre de forma correcta el nombre de su establecimiento educativo</small>
						<select name='id_cole_display' class='form-control select-ie' disabled>
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
						<!-- Campo hidden para enviar el id_cole -->
						<input type="hidden" name="id_cole" value="<?php echo $id_cole; ?>">
					</div>

					<div class="form-group">
						<label for="obs_edu_ini"><i class="fas fa-comment-alt"></i> <strong>OBSERVACIONES y/o COMENTARIOS ADICIONALES</strong></label>
						<small class="text-muted d-block mb-2">Numero de caracteres permitido: <span class="text-primary font-weight-bold">10000</span></small>
						<textarea class="observaciones-textarea" name="obs_edu_ini" rows="5" maxlength="10000" placeholder="Ingrese sus observaciones y comentarios adicionales aqui..." style="width: 100%; border: 1px solid #ccc; padding: 10px; font-size: 14px; min-height: 80px; box-sizing: border-box; resize: vertical;"></textarea>
					</div>

					<div class="form-group">
						<label for="archivo"><i class="fas fa-file-pdf"></i> <strong>ADJUNTAR DOCUMENTOS DEL CAPITULO INICIAL</strong></label>
						<div class="file-input-container">
							<i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
							<input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/msexcel, application/msword, application/pdf, application/rtf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*">
							<div class="mt-3">
								<small class="text-info">
									<i class="fas fa-info-circle"></i> 
									<strong>Instrucciones:</strong> 
									Puede adjuntar varios archivos manteniendo presionada la tecla "CTRL" y seleccionando cada archivo. 
									Formatos permitidos: <strong>PDF, Excel, Word, PowerPoint e Imagenes</strong>
								</small>
							</div>
						</div>
					</div>
					
					<div class="text-center mt-4">
						<button type="submit" class="btn btn-primary btn-lg mr-3">
							<i class="fas fa-save"></i>
							GUARDAR y/o ALMACENAR DATOS CAPITULO INICIAL
						</button>
						<button type="button" class="btn btn-outline-dark btn-lg" onclick="history.back();">
							<i class="fas fa-arrow-left"></i> REGRESAR
						</button>
					</div>
				</form>
			</div>
		</div>

	</body>
</html>