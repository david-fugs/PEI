<?php
	include("../../conexion.php");
	$id_area=intval($_REQUEST['id_area']);
	$asignaturas = $mysqli->prepare("SELECT * FROM asignaturas WHERE id_area = '$id_area'") or die(mysqli_error());
		echo '<option value = ""> </option>';
	if($asignaturas->execute()){
		$a_result = $asignaturas->get_result();
	}
		while($row = $a_result->fetch_array()){
			echo '<option value = "'.$row['id_asig'].'">'.utf8_encode( $row['nombre_asig']).'</option>';
		}
?>