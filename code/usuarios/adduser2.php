<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RISPRO | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    
    <center>
        <img src="../../img/gobersecre.png" class="responsive">
    </center>
    <br/>

   	<?php
        include("../../conexion.php");
	    if(isset($_POST['btn-update']))
        {
            $id             =   $_POST['id'];
            $usuario        =   $_POST['usuario'];
            $nombre         =   $_POST['nombre'];
            $tipo_usuario   =   $_POST['tipo_usuario'];
            //if($_POST['id_cole']==0){$id_cole=0;}
            $id_cole        =   $_POST['id_cole'];
           
            $update = "UPDATE usuarios SET usuario='".$usuario."', nombre='".$nombre."', tipo_usuario='".$tipo_usuario."', id_cole='".$id_cole."' WHERE id='".$id."'";

            $up = mysqli_query($mysqli, $update);
        }
    ?>

   	<div class="container">
       <p align="center"><a href="adduser.php"><img src="../../img/atras.png" width="96" height="96"></a></p>
    </div>

</body>
</html>