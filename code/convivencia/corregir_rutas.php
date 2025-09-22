<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../access.php");
    exit;
}

// Configurar codificación de caracteres
header("Content-Type: text/html; charset=UTF-8");
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

include("../../conexion.php");

// Asegurar que la conexión use UTF-8
if (isset($mysqli)) {
    $mysqli->set_charset("utf8");
}

echo "<h2>Corrección de rutas de archivos</h2>";

// Buscar registros con ruta incorrecta (ruta = "0")
$query = "SELECT * FROM convivencia_escolar WHERE ruta_archivo = '0' OR ruta_archivo = 0";
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    echo "<p>Encontrados " . $result->num_rows . " registros con rutas incorrectas:</p>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<strong>ID:</strong> " . $row['id'] . "<br>";
        echo "<strong>Archivo:</strong> " . $row['nombre_archivo'] . "<br>";
        echo "<strong>Colegio:</strong> " . $row['id_cole'] . "<br>";
        echo "<strong>Año:</strong> " . $row['anio_documento'] . "<br>";
        echo "<strong>Tipo:</strong> " . $row['tipo_documento'] . "<br>";
        echo "<strong>Ruta actual (incorrecta):</strong> " . $row['ruta_archivo'] . "<br>";
        
        // Construir la ruta correcta
        $ruta_correcta = "files/{$row['id_cole']}/{$row['anio_documento']}/convivencia_escolar/{$row['nombre_archivo']}";
        echo "<strong>Ruta correcta:</strong> " . $ruta_correcta . "<br>";
        
        // Verificar si el archivo existe en la ruta correcta
        $archivo_existe = file_exists(__DIR__ . '/' . $ruta_correcta);
        echo "<strong>Archivo existe:</strong> " . ($archivo_existe ? "SÍ" : "NO") . "<br>";
        
        if ($archivo_existe) {
            // Actualizar la ruta en la base de datos
            $update_query = "UPDATE convivencia_escolar SET ruta_archivo = ? WHERE id = ?";
            $stmt = $mysqli->prepare($update_query);
            $stmt->bind_param("si", $ruta_correcta, $row['id']);
            
            if ($stmt->execute()) {
                echo "<strong style='color: green;'>✅ RUTA CORREGIDA EXITOSAMENTE</strong><br>";
            } else {
                echo "<strong style='color: red;'>❌ ERROR AL ACTUALIZAR: " . $stmt->error . "</strong><br>";
            }
            $stmt->close();
        } else {
            echo "<strong style='color: orange;'>⚠️ No se puede corregir: archivo no encontrado</strong><br>";
        }
        
        echo "</div>";
    }
} else {
    echo "<p>No se encontraron registros con rutas incorrectas.</p>";
}

echo "<br><a href='convivenciaEscolar.php'>Volver a Convivencia Escolar</a>";
?>