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
        <script src="js/64d58efce2.js" ></script>
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
    </head>
    <body>

		<center>
	    	<img src='../../../img/logo_educacion_fondo_azul.png' width="600" height="111" class="responsive">
		</center>
		<BR/>

		<section class="principal">

			<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

				<div align="center">
					<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-school"></i> CONSOLIDACIÓN MEJORAS POR SEDES EDUCATIVAS</b></h1>
				</div>
	    		<br />

<?php

	date_default_timezone_set("America/Bogota");
	include("../../../conexion.php");
	
	$query = "SELECT * FROM colegios WHERE id_cole=$id_cole";
	$res = $mysqli->query($query);

	echo "<div class='container'>
        	<table class='table'>
            	<thead>
					<tr>
						<th>No.</th>
						<th>DANE</th>
						<th>NIT</th>
		        		<th>ESTABLECIMIENTO</th>
		        		<th>VERIFICAR</th>
		    		</tr>
		  		</thead>
            <tbody>";

	$consulta = "SELECT * FROM colegios WHERE id_cole=$id_cole";
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{
 
		echo '
				<tr>
					<td data-label="No.">'.$i++.'</td>
					<td data-label="DANE">'.$row['cod_dane_cole'].'</td>
					<td data-label="NIT">'.$row['nit_cole'].'</td>
					<td data-label="ESTABLECIMIENTO">'.$row['nombre_cole'].'</td>
					<td data-label="VERIFICAR"><a href="addmejorasedit.php?cod_dane_cole='.$row['cod_dane_cole'].'"><img src="../../../img/check.png" width=25 heigth=25></td>
				</tr>';
	}
 
	echo '</table>';
	
?>

		<center>
		<br/><a href="../../../access.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

			</div>

		</section>

	</body>
</html>