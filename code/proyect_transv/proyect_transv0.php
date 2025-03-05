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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>TIC | SOFT</title>
        <script src="js/64d58efce2.js" ></script>
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
		<link href="../../fontawesome/css/all.css" rel="stylesheet">
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
    	</style>
    </head>
    <body>

<section class="container">

			<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

				<div align="center">
					<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-list-alt"></i> ESTADO ACTUAL DE LOS PROYECTOS PEDAGÓGICOS TRANSVERSALES </b></h1>
					<p align="justify"><font size=4 color=#000000>Teniendo en cuenta que los artículos: 14 de la ley 115 de 1994, 36 de decreto 1860 de 1994; 10 de la ley 1503 de 2011, 5 del decreto 2851 de 2013; y 15 (literales 1 y 4), y 20 de la ley 1620 de 2013 establecen el marco normativo obligatorio de los Proyectos trasversales en la educación para su diseño y desarrollo, a la vez que brindan lineamientos y orientaciones para su adecuada implementación, la Secretaría de Educación de Risaralda les solicita responder las siguientes preguntas para determinar el estado actual de los proyectos en los doce municipios no certificados en educación y conocer las necesidades de los EE.</font></p>
				</div>
	    		<br />

			</div>

<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	
	$query = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole INNER JOIN planta ON planta.cod_dane_sede=sedes.cod_dane_sede INNER JOIN usuarios ON usuarios.id=planta.id_usu WHERE planta.id_usu=$id";
	$res = $mysqli->query($query);

	echo "<div class='container'>
        	<table class='table'>
            	<thead>
					<tr>
						<th>I.E.</th>
		        		<th>INGRESAR</th>
		    		</tr>
		  		</thead>
            <tbody>";

	$consulta = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole INNER JOIN planta ON planta.cod_dane_sede=sedes.cod_dane_sede INNER JOIN usuarios ON usuarios.id=planta.id_usu WHERE planta.id_usu=$id";
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{
 
		echo '
				<tr>
					<td data-label="I.E.">'.$row['nombre_cole'].'</td>
					<td data-label="INGRESAR"><a href="plan_uso1.php?id_cole='.$row['id_cole'].'"><img src="../../img/ie.png" width=20 heigth=20></td>
				</tr>';
	}
 
	echo '</table>';
	
?>

<BR>
			<hr style="border: 4px dotted #0DF649; border-radius: 5px;">
			<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">



		<center>
		<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

			</div>

		</section>

	</body>
</html>