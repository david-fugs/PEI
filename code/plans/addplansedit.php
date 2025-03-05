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
</head>
<body >
   	<?php
        include("../../conexion.php");
	    $id_proy_plan  = $_GET['id_proy_plan'];
	    if(isset($_GET['id_proy_plan']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM proyectos_planes WHERE id_proy_plan = '$id_proy_plan'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo_educacion_fondo_azul.png' width="600" height="111" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fas fa-project-diagram"></i>  ACTUALIZAR INFORMACIÓN DE LOS PLANES y/o PROYECTOS</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='addplansedit1.php' enctype="multipart/form-data" method="POST">
            
            <div class="row">
                <div class="col">
                    <input type="number" name='id_proy_plan' class='form-control' hidden value='<?php echo $row['id_proy_plan']; ?>' />
                </div>  
            </div>
            
            <div class="form-group">
                <div class="row">
                    <label for="id_cole">NOMBRE DEL ESTABLECIMIENTO EDUCATIVO (verifique que muestre de forma correcta el nombre de su establecimiento educativo):</label>
                        <select name='id_cole' class='form-control' readonly/>
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
                        <label for="nombre_proy_plan">* NOMBRE DEL PROYECTO y/o PLAN:</label>
                        <select class="form-control" name="nombre_proy_plan" required id="selectProy">
                            <option value=""></option>
                            <option value="PLAN DE ORIENTACION SOCIO OCUPACIONAL" <?php if($row['nombre_proy_plan']=='PLAN DE ORIENTACION SOCIO OCUPACIONAL'){echo 'selected';} ?>>PLAN DE ORIENTACION SOCIO OCUPACIONAL</option>
                            <option value="PROYECTO PEDAGOGICO PRODUCTIVO" <?php if($row['nombre_proy_plan']=='PROYECTO PEDAGOGICO PRODUCTIVO'){echo 'selected';} ?>>PROYECTO PEDAGOGICO PRODUCTIVO</option>
                            <option value="PLAN DE RIESGOS" <?php if($row['nombre_proy_plan']=='PLAN DE RIESGOS'){echo 'selected';} ?>>PLAN DE RIESGOS</option>
                            <option value="PLAN DE TRAYECTORIAS EDUCATIVAS COMPLETA" <?php if($row['nombre_proy_plan']=='PLAN DE TRAYECTORIAS EDUCATIVAS COMPLETA'){echo 'selected';} ?>>PLAN DE TRAYECTORIAS EDUCATIVAS COMPLETA</option>
                            <option value="OTRO" <?php if($row['nombre_proy_plan']=='OTRO'){echo 'selected';} ?>>OTRO</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="tipo_proy_plan">Si se contestó "OTROS" en la anterior selección, por favor escriba el tipo de proyecto y/o plan en este recuadro:</label>
                        <input type='text' name='tipo_proy_plan' class='form-control' id="tipo_proy_plan" style="text-transform:uppercase;" value='<?php echo $row['tipo_proy_plan']; ?>' />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <label for="obs_proy_plan">OBSERVACIONES y/o COMENTARIOS ADICIONALES: (número de caracteres permitido-> <span></span>)</label>
                        <textarea class="form-control" rows="5" cols="122" maxlength="500" name="obs_proy_plan" style="text-transform:uppercase;" ><?php echo $row['obs_proy_plan']; ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR DOCUMENTOS RELACIONADOS CON EL PROYECTO y/o PLAN:</label>
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/msexcel, application/msword, application/pdf, application/rtf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*">
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
</body>
</html>