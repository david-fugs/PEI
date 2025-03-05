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
	    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PEI | SOFT</title>
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
	    <link href="../../fontawesome/css/all.css" rel="stylesheet">
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

		<script type = "text/javascript">
		  $(document).ready(function(){
		    $('#id_area').on('change', function(){
		        if($('#id_area').val() == ""){
		          $('#id_asig').empty();
		          $('<option value = "">Selecciona la asignatura</option>').appendTo('#id_asig');
		          $('#id_asig').attr('disabled', 'disabled');
		        }else{
		          $('#id_asig').removeAttr('disabled', 'disabled');
		          $('#id_asig').load('asignaturas_get.php?id_area=' + $('#id_area').val());
		        }
		    });
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
        	<div class="row">
            	<div class="col-md-12">
            		<?php 
	                    if(isset($_SESSION['status']))
	                    {
	                        ?>
	                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
	                            <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
	                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	                            </div>
	                        <?php
	                        unset($_SESSION['status']);
	                    }
	                ?>
	                <div class="card mt-4">
	                    <div class="card-header">
	                        <h1><b><i class="fas fa-user-clock"></i> INTENSIDAD HORARIA</b></h1>
							<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
	                            <a href="javascript:void(0)" class="add-more-form float-end btn btn-primary">AGREGAR</a>
	                        </h4>
	                    </div>
                    <div class="card-body">

                        <form action="addhours2.php" enctype="multipart/form-data" method="POST">

                        	<div class="form-group">
			                	<div class="row">
			                    	<div class="col">
				                        <label for="id_area">* SELECCIONE EL ÁREA:</label>
				                        <select id="id_area" class="form-control" name="id_area" required="required">
							                <option value=""></option>
							                <?php
							                  $sql = $mysqli->prepare("SELECT * FROM areas");
							                  if($sql->execute()){
							                    $g_result = $sql->get_result();
							                  }
							                  while($row = $g_result->fetch_array()){
							                ?>
							                  <option value="<?php echo $row['id_area']?>"><?php echo utf8_encode($row['nombre_area'])?></option>
							                <?php
							                    }
							                  $mysqli->close(); 
							                ?>
							            </select>
			                    	</div>
			                    	<div class="col">
			                        	<label for="id_asig">* POR FAVOR SELECCIONE LA ASIGNATURA:</label>
				                        <select id="id_asig" name="id_asig" class="form-control" disabled="disabled" required="required">
			                				<option value = "">Selecciona la asignatura</option>
			          					</select>
			                   		</div>
			               		</div>
			                </div>

                            <div class="main-form mt-3 border-bottom">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="">DIGITE EL GRADO:</label>
                                            <input type="number" name="grado_int_hor[]" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <label for="">INTENSIDAD HORARIA SEMANAL:</label>
                                            <input type="text" name="horas_int_hor[]" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
	                        				<button type="button" class="remove-btn btn btn-danger">Eliminar</button>
	                    				</div>
	                    			</div>
                                </div>
                            </div>
      

                            <div class="paste-new-forms"></div>

                            <button type="submit" name="save_multiple_data" class="btn btn-primary">INGRESAR INFORMACIÓN INTENSIDAD HORARIA</button>
                            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'>	<img src='../../img/atras.png' width=27 height=27> REGRESAR
							</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.remove-btn', function () {
                $(this).closest('.main-form').remove();
            });
            
            $(document).on('click', '.add-more-form', function () {
                $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
                                <div class="row">\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <label for="">DIGITE EL GRADO:</label>\
                                            <input type="number" name="grado_int_hor[]" class="form-control" >\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <label for="">INTENSIDAD HORARIA SEMANAL:</label>\
                                            <input type="text" name="horas_int_hor[]" class="form-control" >\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <div class="form-group mb-2">\
                                            <br>\
                                            <button type="button" class="remove-btn btn btn-danger">Eliminar</button>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>');
            });

        });
    </script>
    	
	</body>
	<script src = "../../js/jquery-3.1.1.js"></script>
	<script type = "text/javascript">
	  $(document).ready(function(){
	    $('#id_area').on('change', function(){
	        if($('#id_area').val() == ""){
	          $('#id_asig').empty();
	          $('<option value = "">Selecciona la asignatura</option>').appendTo('#id_asig');
	          $('#id_asig').attr('disabled', 'disabled');
	        }else{
	          $('#id_asig').removeAttr('disabled', 'disabled');
	          $('#id_asig').load('asignaturas_get.php?id_area=' + $('#id_area').val());
	        }
	    });
	  });
	</script>
</html>