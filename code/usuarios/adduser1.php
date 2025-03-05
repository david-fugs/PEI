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
</head>
<body >
   	<?php
        include("../../conexion.php");
	    $id = $_GET['id'];
	    if(isset($_GET['id']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id = '$id'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src="../../img/gobersecre.png" width="400" height="188" class="responsive">
        </center>
        <BR/>
        <h2><b>ACTUALIZAR INFORMACIÓN DEL USUARIO</b></h2>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='adduser2.php' method='post'>
            
             <div class="form-row">
                <label>
                    <input type="text" name="id" hidden readonly value="<?php echo $row['id']; ?>">
                </label>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="usuario">* USUARIO:</label>
                        <input type='text' name='usuario' class='form-control' value='<?php echo $row['usuario']; ?>' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="nombre">* NOMBRE DEL USUARIO:</label>
                        <input type='text' name='nombre' class='form-control' value='<?php echo utf8_encode($row['nombre']); ?>' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="tipo_usuario">* TIPO DE USUARIO:</label>
                        <select class="form-control" name="tipo_usuario" required>
                            <option value=""></option>
                            <option value=1 <?php if($row['tipo_usuario']==1){echo 'selected';} ?>>Administrador</option>
                            <option value=2 <?php if($row['tipo_usuario']==2){echo 'selected';} ?>>I.E.</option>
                            <option value=3 <?php if($row['tipo_usuario']==3){echo 'selected';} ?>>No validado</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="id_cole">ESTABLECIMIENTO EDUCATIVO:</label>
                        <select name='id_cole' class='form-control' id="selectIE" readonly/>
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta='SELECT * FROM colegios';
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row1 = $res->fetch_array())
                                    {
                                    ?>
                            <option value='<?php echo $row1['id_cole']; ?>'<?php if($row['id_cole']==$row1['id_cole']){echo 'selected';} ?>>
                                <?php echo $row1['nombre_cole']; ?>
                            </option>
                                    <?php
                                    }
                                    ?>    
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-warning" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                ACTUALIZAR INFORMACIÓN DEL USUARIO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
</html>