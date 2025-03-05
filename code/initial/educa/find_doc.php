<?php
	
  session_start();
    
  if(!isset($_SESSION['id'])){
      header("Location: index.php");
  }
  
  header("Content-Type: text/html;charset=utf-8");
  $nombre = $_SESSION['nombre'];
  $tipo_usuario = $_SESSION['tipo_usuario'];
  
  include("../../../conexion.php");
	
	$id_edu_ini = $_GET['id_edu_ini'];
  
	$sql = "SELECT * FROM educa_inicial WHERE id_edu_ini = '$id_edu_ini'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
 
?>
<html lang="es">
  <head> 
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | SOFT</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="../../../js/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../css/estilos.css">
    <link href="../../../fontawesome/css/all.css" rel="stylesheet">
    <style>
          .responsive {
              max-width: 100%;
              height: auto;
          }
    </style>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.delete').click(function(){
          var parent = $(this).parent().attr('id_insert');
          var service = $(this).parent().attr('data');
          var dataString = 'id_insert='+service;

          $.ajax({
            type: "POST",
            url: "del_file.php",
            data: dataString,
            success: function(){
              location.reload();
            }
          });
        });
      });
    </script>
  </head>
    <body>

    <center>
        <img src="../../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
    </center>
    <BR/>

     <section class="principal">

      <div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

        <div align="center">

          <h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-folder-open"></i> DOCUMENTOS CAPÍTULO EDUCACIÓN INICIAL </b></h1>

        </div>

      <?php 
        $path = "files/".$id_edu_ini;
         echo "<div class='container'>
                <table class='table'>
                    <tr>
                      <th>DOCUMENTO</th>
                    </tr>";
        if(file_exists($path))
        {
          $directorio = opendir($path);
          while ($archivo = readdir($directorio))
          {
            if (!is_dir($archivo))
            {
              echo "<tr>
                      <td data-label='DOCUMENTO'><div data='".$path."/".$archivo."'><a href='".$path."/".$archivo."' title='Ver Archivo Adjunto' target=_blank><img src='../../../img/files1.png' width=50 heigth=50></a><br>".$archivo."<br><a href='#' class='delete'><h2><span class='glyphicon glyphicon-trash' aria-hidden='true' title='Eliminar el Archivo Adjunto'></span></h2></a></div></td>
                    </tr>";
            }
          }
        echo '</table>';
        }
      ?>
    <center>
    <br/><a href="../../../access.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

      </div>

    </section>

  </body>
</html>