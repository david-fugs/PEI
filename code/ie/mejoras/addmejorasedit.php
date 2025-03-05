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
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
		<link rel="stylesheet" href="../../../css/bootstrap.min.css">
		<script src="jquery-3.1.1.js" ></script>
		<script src="main.js" ></script>
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

		<div class="container">
			<h1><b><i class="fas fa-tasks"></i> VERIFICACIÓN SEDES Y JORNADA ÚNICA</b></h1>
			<hr style="border: 2px dotted #09F287; border-radius: 1px;">
				<p align="justify"><font size=4 color=#000000>Debe realizar el proceso de verificación con respecto a las sedes que se listan, si existe alguna novedad, por favor debe diligenciar el siguiente formulario: <a href="https://forms.gle/nrPuPAH6YrxrTmnx6" target="_blank"><b><u>Solicitar Requerimiento</u></b></a><br/><B>NO CONTINÚE CON ESTE PROCESO DE VALIDACIÓN Y VERIFICACIÓN,</B> hasta cuando haya sido solucionado su solicitud o requerimiento, el cual será notificado a través <b><u>del correo electrónico o llamada telefónica</u></b><br/>Si no presenta inconvenientes con las Sedes listadas, por favor identifique las que cuentan con <i><b>Jornada Única</b></i> e indique si aplica para primaria, secundaria o ambas.</font></p>
			<hr style="border: 2px dotted #09F287; border-radius: 1px;">
			
			<form method="POST" action=".php" enctype="multipart/form-data" method="POST">


<?php

	date_default_timezone_set("America/Bogota");
	include("../../../conexion.php");
	
	$query = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
	$res = $mysqli->query($query);

	echo "<div class='row'> 	
			<table class='table table-bordered'>
            	<thead>
					<tr>
						<th>No.</th>
						<th>DANE</th>
						<th>SEDE</th>
		        		<th>ZONA</th>
		        		<th>¿JORNADA ÚNICA?</th>
		        		<th>J.U. EN PRIMARIA</th>
		        		<th>J.U. EN SECUNDARIA</th>
		        		<th>J.U. MEDIA</th>
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
					<td data-label="¿JORNADA ÚNICA?">
						<select class="form-control" name="jornada_unica_sede[]" required style="height: 35px">
	                    	<option value=""></option>   
                            <option value="SI">SI</option>
                            <option value="NO" selected>NO</option>
	                    </select>
	                </td>
	                <td data-label="J.U. EN PRIMARIA">
						<select class="form-control" name="ju_primaria_sede[]" required style="height: 35px">
	                    	<option value=""></option>   
                            <option value="SI">SI</option>
                            <option value="NO" selected>NO</option>
	                    </select>
	                </td>
	                <td data-label="J.U. EN SECUNDARIA">
						<select class="form-control" name="ju_secundaria_sede[]" required style="height: 35px">
	                    	<option value=""></option>   
                            <option value="SI">SI</option>
                            <option value="NO" selected>NO</option>
	                    </select>
	                </td>
	                <td data-label="J.U. MEDIA">
						<select class="form-control" name="ju_secundaria_sede[]" required style="height: 35px">
	                    	<option value=""></option>   
                            <option value="SI">SI</option>
                            <option value="NO" selected>NO</option>
	                    </select>
	                </td>
				</tr>';
	}
 
	echo '</tbody>
			</table>
				</div>
					<p align="center">
						<label>* <i class="fas fa-file-pdf"></i> ADJUNTAR ACTO(s) ADMINISTRATIVO(s) CORRESPONDIENTE(s) A LA AUTORIZACIÓN DE JORNADA ÚNICA:</label>
						<input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf" >
						<p style="font-family: "Rajdhani", sans-serif; color: #c68615; text-align: justify;"><b><u>Adjunte el o los Actos Administrativos más recientes,</u>deben coincidir</b> con la o las sedes que cuentan con <B>Jornada Única (las cuales usted seleccionó con la opción "SI").</B> Recuerde que puede <I>adjuntar varios archivos a la vez,</I> simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir.<BR><B>Utilice <U>ÚNICAMENTE </U>archivos de tipo: PDF</p>
						</p>
						<button type="submit" class="btn btn-success" name="insertar">
							<span class="spinner-border spinner-border-sm"></span><i class="fas fa-list-ol"></i> APLICAR LA JORNADA ÚNICA A LAS SEDES VERIFICADAS
						</button>
						
		  			</form>
		  		
					<center>
					<br/><a href="addsedes.php"><img src="../../../img/atras.png" width="72" height="72" title="Regresar" /></a>
				</center>

			</div>

	</body>
</html>';
?>