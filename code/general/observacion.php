<?php
include("./../../conexion.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['id_cole']) && isset($_POST['nueva_observacion'])) {
        $id_cole = $_POST['id_cole'];
        $nueva_observacion = $_POST['nueva_observacion'];

        if (ActualizarObservacion($id_cole, $nueva_observacion, $mysqli)) {
            echo 'Observación actualizada exitosamente.';
           
        } else {
            echo 'Error al actualizar la observación.';
        }
    } else {
        echo 'Datos del formulario incompletos.';
    }
} else {
    // echo 'Acceso no permitido.';
}



function ActualizarObservacion($id_cole, $nueva_observacion, $mysqli) {
    
    $nueva_observacion = mysqli_real_escape_string($mysqli, $nueva_observacion);

    // Verificar si ya existe un registro para el colegio
    $query = "SELECT id FROM observacion WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Ya existe un registro, actualízalo
        $query = "UPDATE observacion SET contenido = '$nueva_observacion' WHERE id_cole = $id_cole";
    } else {
        // No existe un registro, crea uno nuevo
        $query = "INSERT INTO observacion (id_cole, contenido) VALUES ($id_cole, '$nueva_observacion')";
    }

    if (mysqli_query($mysqli, $query)) {
        return true;
    } else {
        return false;
    }
}



function MostrarInformacionObservacion($id_cole, $mysqli) {
    $query = "SELECT * FROM observacion WHERE id_cole = $id_cole"; // Consulta SQL para seleccionar los registros de la tabla "observacion" para un colegio específico
    
    // Ejecutar la consulta
    $result = mysqli_query($mysqli, $query);
    $contenido = "";
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Concatenar los contenidos con un separador (por ejemplo, un salto de línea)
            $contenido .= $row['contenido'] . "\n";
        }
        
        mysqli_free_result($result);
    } else {
        $contenido = 'Error al obtener la información de la observación.';
    }
    
    return $contenido;
}


?>
