<?php
// Archivo de prueba para verificar el módulo de Convivencia Escolar
// Ejecutar desde el navegador: http://localhost/PEI/code/convivencia/test_convivencia_escolar.php

session_start();
header("Content-Type: text/html; charset=UTF-8");

// Verificar si el usuario está logueado (simulación para pruebas)
if (!isset($_SESSION['id'])) {
    echo "<h3>Para ejecutar las pruebas, primero debe iniciar sesión en el sistema.</h3>";
    echo "<a href='../../access.php'>Iniciar sesión</a>";
    exit;
}

include("../../conexion.php");

// Asegurar que la conexión use UTF-8
if (isset($mysqli)) {
    $mysqli->set_charset("utf8mb4");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Convivencia Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <style>
        .test-section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .test-ok {
            color: green;
        }
        .test-error {
            color: red;
        }
        .test-warning {
            color: orange;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-vial"></i> Test del Módulo de Convivencia Escolar</h1>
        
        <div class="test-section">
            <h3>1. Verificación de Archivos</h3>
            <?php
            $archivos_requeridos = [
                'convivenciaEscolar.php' => 'Página principal',
                'subirConvivenciaEscolar.php' => 'Formulario de subida',
                'procesarConvivenciaEscolar.php' => 'Procesamiento de archivos',
                'eliminarConvivenciaEscolar.php' => 'Eliminación de documentos',
                'crear_tabla_convivencia_escolar.sql' => 'Script SQL'
            ];
            
            foreach ($archivos_requeridos as $archivo => $descripcion) {
                $existe = file_exists($archivo);
                $clase = $existe ? 'test-ok' : 'test-error';
                $icono = $existe ? 'fa-check' : 'fa-times';
                echo "<p class='$clase'><i class='fas $icono'></i> $archivo - $descripcion</p>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>2. Verificación de la Base de Datos</h3>
            <?php
            // Verificar si la tabla existe
            $result = $mysqli->query("SHOW TABLES LIKE 'convivencia_escolar'");
            if ($result->num_rows > 0) {
                echo "<p class='test-ok'><i class='fas fa-check'></i> Tabla 'convivencia_escolar' existe</p>";
                
                // Verificar estructura de la tabla
                $result = $mysqli->query("DESCRIBE convivencia_escolar");
                $columnas_esperadas = [
                    'id', 'id_cole', 'anio_documento', 'tipo_documento', 'nombre_archivo', 
                    'nombre_original', 'version', 'descripcion', 'numero_acta', 'fecha_reunion',
                    'ruta_archivo', 'tamano_archivo', 'fecha_subida', 'id_usuario', 'activo'
                ];
                $columnas_existentes = [];
                
                while ($row = $result->fetch_assoc()) {
                    $columnas_existentes[] = $row['Field'];
                }
                
                foreach ($columnas_esperadas as $columna) {
                    $existe = in_array($columna, $columnas_existentes);
                    $clase = $existe ? 'test-ok' : 'test-error';
                    $icono = $existe ? 'fa-check' : 'fa-times';
                    echo "<p class='$clase'><i class='fas $icono'></i> Columna '$columna'</p>";
                }
                
            } else {
                echo "<p class='test-error'><i class='fas fa-times'></i> Tabla 'convivencia_escolar' no existe</p>";
                echo "<p class='test-warning'><i class='fas fa-exclamation-triangle'></i> Ejecute el script SQL para crear la tabla</p>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>3. Verificación de Permisos de Carpetas</h3>
            <?php
            $id_cole = $_SESSION['id_cole'] ?? 1;
            $carpeta_base = "files";
            $carpeta_completa = "files/{$id_cole}/2024/convivencia_escolar";
            
            // Verificar si la carpeta base existe
            if (!is_dir($carpeta_base)) {
                if (mkdir($carpeta_base, 0777, true)) {
                    echo "<p class='test-ok'><i class='fas fa-check'></i> Carpeta base creada: $carpeta_base</p>";
                } else {
                    echo "<p class='test-error'><i class='fas fa-times'></i> No se pudo crear la carpeta base: $carpeta_base</p>";
                }
            } else {
                echo "<p class='test-ok'><i class='fas fa-check'></i> Carpeta base existe: $carpeta_base</p>";
            }
            
            // Verificar permisos de escritura
            if (is_writable($carpeta_base)) {
                echo "<p class='test-ok'><i class='fas fa-check'></i> Carpeta base tiene permisos de escritura</p>";
            } else {
                echo "<p class='test-error'><i class='fas fa-times'></i> Carpeta base NO tiene permisos de escritura</p>";
            }
            
            // Crear estructura de carpetas de prueba
            if (!is_dir($carpeta_completa)) {
                if (mkdir($carpeta_completa, 0777, true)) {
                    echo "<p class='test-ok'><i class='fas fa-check'></i> Estructura de carpetas creada: $carpeta_completa</p>";
                } else {
                    echo "<p class='test-error'><i class='fas fa-times'></i> No se pudo crear la estructura: $carpeta_completa</p>";
                }
            } else {
                echo "<p class='test-ok'><i class='fas fa-check'></i> Estructura de carpetas existe: $carpeta_completa</p>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>4. Verificación de Configuración PHP</h3>
            <?php
            $configuraciones = [
                'upload_max_filesize' => '50M',
                'post_max_size' => '50M',
                'max_execution_time' => '300',
                'memory_limit' => '256M'
            ];
            
            foreach ($configuraciones as $config => $recomendado) {
                $valor_actual = ini_get($config);
                echo "<p class='test-ok'><i class='fas fa-info-circle'></i> $config: $valor_actual (recomendado: $recomendado)</p>";
            }
            
            // Verificar extensiones
            $extensiones = ['mbstring', 'fileinfo'];
            foreach ($extensiones as $ext) {
                $cargada = extension_loaded($ext);
                $clase = $cargada ? 'test-ok' : 'test-error';
                $icono = $cargada ? 'fa-check' : 'fa-times';
                echo "<p class='$clase'><i class='fas $icono'></i> Extensión '$ext'</p>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3>5. Verificación UTF-8</h3>
            <?php
            $mysqli->set_charset("utf8mb4");
            
            // Crear una prueba de caracteres especiales
            $texto_prueba = "Año 2024 - Educación - Niños";
            $charset = $mysqli->character_set_name();
            
            echo "<p class='test-ok'><i class='fas fa-check'></i> Charset de conexión: $charset</p>";
            echo "<p class='test-ok'><i class='fas fa-check'></i> Texto de prueba: $texto_prueba</p>";
            echo "<p class='test-ok'><i class='fas fa-check'></i> Codificación HTML: " . htmlspecialchars($texto_prueba) . "</p>";
            ?>
        </div>
        
        <div class="test-section">
            <h3>6. Enlaces de Navegación</h3>
            <div class="row">
                <div class="col-md-4">
                    <a href="convivenciaEscolar.php" class="btn btn-primary btn-block">
                        <i class="fas fa-users"></i> Convivencia Escolar
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="subirConvivenciaEscolar.php?tipo=conformacion" class="btn btn-success btn-block">
                        <i class="fas fa-upload"></i> Subir Conformación
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="../../index.php" class="btn btn-secondary btn-block">
                        <i class="fas fa-home"></i> Ir al Inicio
                    </a>
                </div>
            </div>
        </div>
        
        <div class="test-section">
            <h3>7. Información del Sistema</h3>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Usuario actual:</strong> <?php echo $_SESSION['nombre'] ?? 'No definido'; ?></p>
            <p><strong>ID Colegio:</strong> <?php echo $_SESSION['id_cole'] ?? 'No definido'; ?></p>
            <p><strong>Fecha actual:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        
        <div class="text-center mt-4">
            <a href="convivenciaEscolar.php" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-right"></i> Ir al Módulo de Convivencia Escolar
            </a>
        </div>
    </div>
</body>
</html>
