<?php
     
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $id 			= $_SESSION['id'];
    $usuario 		= $_SESSION['usuario'];
    $nombre 		= $_SESSION['nombre'];
    $tipo_usuario 	= $_SESSION['tipo_usuario'];
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
    </head>
    <body>

		<center>
	    	<img src='../../img/logo_educacion_fondo_azul.png' width="600" height="111" class="responsive">
		</center>
		<BR/>

		<section class="principal">

			<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

				<div align="center">
					<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-school"></i> INFORMACIÓN SEDES DEL ESTABLECIMIENTOS EDUCATIVO</b></h1>
				</div>
	    		<br />

<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	
	$query = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
	$res = $mysqli->query($query);

	echo "<div class='container'>
        	<table class='table'>
            	<thead>
					<tr>
						<th>No.</th>
						<th>DANE</th>
						<th>SEDE</th>
		        		<th>ZONA</th>
		        		<th>VERIFICAR</th>
		    		</tr>
		  		</thead>
            <tbody>";

	$consulta = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{
 	
		echo '
				<tr>
					<td data-label="No.">'.$i++.'</td>
					<td data-label="DANE">'.$row['cod_dane_sede'].'</td>
					<td data-label="SEDE">'.$row['nombre_sede'].'</td>
					<td data-label="ZONA">'.$row['zona_sede'].'</td>
					<th data-label="VERIFICAR"><a href="addsedesedit.php?cod_dane_sede='.$row['cod_dane_sede'].'"><img src="../../img/check.png" width=25 heigth=25></td>
				</tr>';

	}
 
	echo '</tbody>
			</table>
				</div>';
?>

		<center>
		<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

			</div>

		</section>

	</body>
</html>