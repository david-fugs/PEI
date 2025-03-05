<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

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
    	<!--SCRIPT PARA VALIDAR SI EL REGISTRO YA ESTÁ EN LA BD-->
    	<script type="text/javascript">
    		$(document).ready(function()
    		{  
        		$('#nit_cole').on('blur', function()
        		{
            		$('#result-nit_cole').html('<img src="../../img/loader.gif" />').fadeOut(1000);
             		var nit_cole = $(this).val();   
            		var dataString = 'nit_cole='+nit_cole;

            		$.ajax(
            		{
		                type: "POST",
		                url: "chkie.php",
		                data: dataString,
		                success: function(data)
		                {
		                	$('#result-nit_cole').fadeIn(1000).html(data);
            			}
            		});
        		});
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
			<h1><b><i class="fas fa-school"></i> REGISTRO ESTABLECIMIENTOS EDUCATIVOS</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addie2.php' enctype="multipart/form-data" method="POST">
				<div class="row">
					<div class="col">
						<div id="result-nit_cole"></div>
					</div>  
				</div>

				<div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="cod_dane_cole">* CÓDIGO DANE:</label>
                        	<input type='number' name='cod_dane_cole' class='form-control' required />
                    	</div>
                    	<div class="col-12 col-sm-6">
                        	<label for="nit_cole">* No. NIT (ejemplo: 910420899-9):</label>
	                        <input type='text' name='nit_cole' class='form-control' minlength="11" maxlength="11" id="nit_cole" required />
                   		</div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
                        	<label for="nombre_cole">* NOMBRE DEL ESTABLECIMIENTO EDUCATIVO:</label>
	                        <input type='text' name='nombre_cole' class='form-control' id="nombre_cole" required style="text-transform:uppercase;" />
                   		</div>
                   		<div class="col-12 col-sm-6">
	                        <label for="direccion_cole">* DIRECCIÓN:</label>
	                        <input type='text' name='direccion_cole' id="direccion_cole" class='form-control' required style="text-transform:uppercase;" />
	                    </div>
               		</div>
                </div>

                <div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
                        	<label for="nombre_rector_cole">* NOMBRE DEL RECTOR:</label>
	                        <input type='text' name='nombre_rector_cole' class='form-control' id="nombre_rector_cole" required style="text-transform:uppercase;" />
                   		</div>
                   		<div class="col-12 col-sm-6">
	                        <label for="tel_rector_cole">* TELÉFONO DE CONTACTO RECTOR:</label>
	                        <input type='text' name='tel_rector_cole' id="tel_rector_cole" class='form-control' required style="text-transform:uppercase;" />
	                    </div>
               		</div>
                </div>

                <hr style="border: 4px solid #04547c; border-radius: 5px;">
	            <h4><b><CENTER>JORNADAS</h4></CENTER></b>
                <div class="form-group">
	                <div class="row">
			            <div class="col-12 col-sm-12">
					        <label class="containerCheck">JORNADA ÚNICA:</label>
					        <input type="hidden" name="jor_1_cole" value=0>  
					        <input type="checkbox" name="jor_1_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
				        </div>
				        <div class="col-12 col-sm-12">
					        <label class="containerCheck">COMPLETA:</label>
					        <input type="hidden" name="jor_2_cole" value=0>
					        <input type="checkbox" name="jor_2_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">COMPLETA Y FIN DE SEMANA:</label>
					        <input type="hidden" name="jor_3_cole" value=0>  
					        <input type="checkbox" name="jor_3_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">COMPLETA Y NOCTURNA:</label>
					        <input type="hidden" name="jor_4_cole" value=0>  
					        <input type="checkbox" name="jor_4_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">COMPLETA, NOCTURNA Y FIN DE SEMANA</label>
					        <input type="hidden" name="jor_5_cole" value=0>
					        <input type="checkbox" name="jor_5_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">MAÑANA:</label>
					        <input type="hidden" name="jor_6_cole" value=0>
					        <input type="checkbox" name="jor_6_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">MAÑANA Y FIN DE SEMANA:</label>
					        <input type="hidden" name="jor_7_cole" value=0>
					        <input type="checkbox" name="jor_7_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">MAÑANA Y NOCTURNA:</label>
					        <input type="hidden" name="jor_8_cole" value=0>
					        <input type="checkbox" name="jor_8_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">MAÑANA, NOCTURNA Y FIN DE SEMANA:</label>
					        <input type="hidden" name="jor_9_cole" value=0>
					        <input type="checkbox" name="jor_9_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">OTRA:</label>
					        <input type="hidden" name="jor_10_cole" value=0>
					        <input type="checkbox" name="jor_10_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
	                </div>
	            </div>
	            <hr style="border: 4px solid #04547c; border-radius: 5px;">

	            <h4><b><CENTER>NIVELES QUE OFRECE</h4></CENTER></b>
                <div class="form-group">
	                <div class="row">
			            <div class="col-12 col-sm-12">
					        <label class="containerCheck">PREESCOLAR:</label>
					        <input type="hidden" name="niv_1_cole" value=0>  
					        <input type="checkbox" name="niv_1_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
				        </div>
				        <div class="col-12 col-sm-12">
					        <label class="containerCheck">BÁSICA PRIMARIA:</label>
					        <input type="hidden" name="niv_2_cole" value=0>
					        <input type="checkbox" name="niv_2_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">BÁSICA SECUNDARIA:</label>
					        <input type="hidden" name="niv_3_cole" value=0>  
					        <input type="checkbox" name="niv_3_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
					    <div class="col-12 col-sm-12">
					        <label class="containerCheck">MEDIA:</label>
					        <input type="hidden" name="niv_4_cole" value=0>  
					        <input type="checkbox" name="niv_4_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
	                </div>
	            </div>
	            <hr style="border: 4px solid #04547c; border-radius: 5px;">

	            <h4><b><CENTER>CARACTER DE LA MEDIA</h4></CENTER></b>
                <div class="form-group">
	                <div class="row">
			            <div class="col-12 col-sm-12">
					        <label class="containerCheck">TÉCNICA:</label>
					        <input type="hidden" name="car_med_1_cole" value=0>  
					        <input type="checkbox" name="car_med_1_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
				        </div>
				        <div class="col-12 col-sm-12">
					        <label class="containerCheck">ACADÉMICA:</label>
					        <input type="hidden" name="car_med_2_cole" value=0>
					        <input type="checkbox" name="car_med_2_cole" value=1>
					        <span class="checkmark"></span>
					        </label>
					    </div>
	                </div>
	            </div>
	            <hr style="border: 4px solid #04547c; border-radius: 5px;">


                <div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-6">
	                        <label for="corregimiento_cole">CORREGIMIENTO:</label>
	                        <input type='text' name='corregimiento_cole' class='form-control' style="text-transform:uppercase;" />
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
	          							while($row = $res->fetch_array())
	          							{
	        							?>
	      						<option value='<?php echo $row['id_mun']; ?>'>
	        							<?php echo utf8_encode($row['nombre_mun']); ?>
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
	                        <input type='text' name='tel1_cole' class='form-control' required style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-6">
	                        <label for="tel2_cole">OTRO TELÉFONO DE CONTACTO:</label>
	                        <input type='text' name='tel2_cole' class='form-control' style="text-transform:uppercase;" />
	                    </div>
	                </div>
	            </div>

	            <div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-4">
	                        <label for="email_cole">EMAIL:</label>
	                        <input type='email' name='email_cole' class='form-control' />
	                    </div>
	                    <div class="col-12 col-sm-4">
	                        <label for="num_act_adm_cole">* NÚMERO RESOLUCIÓN:</label>
	                        <input type='number' name='num_act_adm_cole' class='form-control' required />
	                    </div>
	                    <div class="col-12 col-sm-4">
	                        <label for="fec_res_cole">* FECHA RESOLUCIÓN:</label>
	                        <input type='date' name='fec_res_cole' class='form-control' required />
	                    </div>
                	</div>
            	</div>

            	<div class="form-group">
	                <div class="row">
	                    <div class="col-12">
	                        <label for="obs_cole">OBSERVACIONES ADICIONALES:</label>
	                        <textarea class="form-control" rows="5" name="obs_cole" style="text-transform:uppercase;" /></textarea>
	                    </div>
                	</div>
            	</div>
            	
            	<div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR RESOLUCIÓN VIGENTE:</label>
	                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf" >
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