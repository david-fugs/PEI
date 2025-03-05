<?php
    session_start();
     
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $usuario      = $_SESSION['usuario'];
    $nombre       = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $id_cole      = $_SESSION['id_cole'];
?>

<!DOCTYPE html>
<html lang="es">
    <head>
      <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>PEI | SOFT</title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/popper.min.j"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
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
    <head>
    <body>
  
    <center>
        <img src="img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
    </center>
    <br />
<?php

  date_default_timezone_set("America/Bogota");
  include("conexion.php");
  require_once("zebra.php");

?>

    <div class="container">
      <h1><b><i class="fas fa-school"></i> CONSULTA INFORMACIÓN SOBRE ALGÚN I.E. <i class="fas fa-school"></i></b></h1>
     
      <form action='access1.php' method="POST">
        
        <div class="form-group">
          <div class="row">
            <label for="id_cole">NOMBRE DEL ESTABLECIMIENTO EDUCATIVO:</label>
              <select name='id_cole' class='form-control' id="selectIE" />
                <option value=''></option>
                  <?php
                    $sql = $mysqli->prepare("SELECT * FROM colegios");
                    if($sql->execute()){
                      $g_result = $sql->get_result();
                    }
                    while($row = $g_result->fetch_array()){
                  ?>
                    <option value="<?php echo $row['id_cole']?>"><?php echo utf8_encode($row['nombre_cole'])?></option>
                  <?php
                      }
                    $mysqli->close(); 
                  ?>
              </select>
          </div>
        </div>

        <button type="submit" class="btn btn-success"
          <span class="spinner-border spinner-border-sm"></span>
          GENERAR CONSULTA
        </button>
        <button type="reset" class="btn btn-outline-dark" role='link' onclick="window.location='http://sed2.risaralda.gov.co/CalidadEducativa/PEI/logout.php'"><img src='img/atras.png' width=27 height=27> SALIR
        </button>
      </form>
    </div>

  </body>
</html>