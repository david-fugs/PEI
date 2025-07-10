<?php
// Archivo de instalación automática para el módulo de Convivencia Escolar
// Ejecutar desde el navegador: http://localhost/PEI/code/convivencia/instalar_convivencia_escolar.php

session_start();
header("Content-Type: text/html; charset=UTF-8");

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    echo "<h3>Para ejecutar la instalación, primero debe iniciar sesión en el sistema.</h3>";
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
    <title>Instalador - Convivencia Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <style>
        .install-section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-cogs"></i> Instalador del Módulo de Convivencia Escolar</h1>
        
        <?php
        if (isset($_POST['instalar'])) {
            echo "<div class='install-section'>";
            echo "<h3>Proceso de Instalación</h3>";
            
            // 1. Crear tabla en la base de datos
            echo "<h4>1. Creando tabla en la base de datos...</h4>";
            
            $sql_create_table = "
            SET NAMES utf8mb4;
            SET character_set_client = utf8mb4;
            SET character_set_connection = utf8mb4;
            SET character_set_results = utf8mb4;
            SET collation_connection = utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `convivencia_escolar` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `id_cole` int(11) NOT NULL,
              `anio_documento` int(4) NOT NULL,
              `tipo_documento` enum('conformacion','reglamento','actas') NOT NULL,
              `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1.0',
              `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
              `numero_acta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `fecha_reunion` date DEFAULT NULL,
              `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              `tamano_archivo` bigint(20) NOT NULL,
              `fecha_subida` datetime NOT NULL,
              `id_usuario` int(11) NOT NULL,
              `activo` tinyint(1) DEFAULT 1,
              PRIMARY KEY (`id`),
              KEY `idx_id_cole` (`id_cole`),
              KEY `idx_anio_documento` (`anio_documento`),
              KEY `idx_tipo_documento` (`tipo_documento`),
              KEY `idx_fecha_subida` (`fecha_subida`),
              KEY `idx_convivencia_activo` (`activo`),
              KEY `idx_convivencia_cole_anio_tipo` (`id_cole`, `anio_documento`, `tipo_documento`),
              CONSTRAINT `fk_convivencia_escolar_colegio` FOREIGN KEY (`id_cole`) REFERENCES `colegios` (`id_cole`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($mysqli->multi_query($sql_create_table)) {
                do {
                    // Procesar todos los resultados
                    if ($result = $mysqli->store_result()) {
                        $result->free();
                    }
                } while ($mysqli->next_result());
                
                echo "<p class='success'><i class='fas fa-check'></i> Tabla 'convivencia_escolar' creada exitosamente</p>";
            } else {
                echo "<p class='error'><i class='fas fa-times'></i> Error al crear la tabla: " . $mysqli->error . "</p>";
            }
            
            // 2. Crear índices adicionales
            echo "<h4>2. Creando índices adicionales...</h4>";
            
            $indices = [
                "CREATE INDEX IF NOT EXISTS `idx_convivencia_cole_tipo` ON `convivencia_escolar` (`id_cole`, `tipo_documento`)"
            ];
            
            foreach ($indices as $indice) {
                if ($mysqli->query($indice)) {
                    echo "<p class='success'><i class='fas fa-check'></i> Índice creado exitosamente</p>";
                } else {
                    echo "<p class='warning'><i class='fas fa-exclamation-triangle'></i> Índice ya existe o error: " . $mysqli->error . "</p>";
                }
            }
            
            // 3. Crear estructura de carpetas
            echo "<h4>3. Creando estructura de carpetas...</h4>";
            
            $id_cole = $_SESSION['id_cole'] ?? 1;
            $carpetas = [
                "files",
                "files/{$id_cole}",
                "files/{$id_cole}/2024",
                "files/{$id_cole}/2024/convivencia_escolar"
            ];
            
            foreach ($carpetas as $carpeta) {
                if (!is_dir($carpeta)) {
                    if (mkdir($carpeta, 0777, true)) {
                        echo "<p class='success'><i class='fas fa-check'></i> Carpeta creada: $carpeta</p>";
                    } else {
                        echo "<p class='error'><i class='fas fa-times'></i> Error al crear carpeta: $carpeta</p>";
                    }
                } else {
                    echo "<p class='success'><i class='fas fa-check'></i> Carpeta ya existe: $carpeta</p>";
                }
            }
            
            // 4. Configurar permisos
            echo "<h4>4. Configurando permisos...</h4>";
            if (is_writable("files")) {
                echo "<p class='success'><i class='fas fa-check'></i> Permisos de escritura configurados correctamente</p>";
            } else {
                echo "<p class='warning'><i class='fas fa-exclamation-triangle'></i> Verificar permisos de escritura en la carpeta 'files'</p>";
            }
            
            // 5. Verificar archivos del módulo
            echo "<h4>5. Verificando archivos del módulo...</h4>";
            
            $archivos = [
                'convivenciaEscolar.php',
                'subirConvivenciaEscolar.php',
                'procesarConvivenciaEscolar.php',
                'eliminarConvivenciaEscolar.php'
            ];
            
            foreach ($archivos as $archivo) {
                if (file_exists($archivo)) {
                    echo "<p class='success'><i class='fas fa-check'></i> Archivo encontrado: $archivo</p>";
                } else {
                    echo "<p class='error'><i class='fas fa-times'></i> Archivo faltante: $archivo</p>";
                }
            }
            
            echo "<div class='alert alert-success mt-4'>";
            echo "<h4><i class='fas fa-check-circle'></i> Instalación Completada</h4>";
            echo "<p>El módulo de Convivencia Escolar ha sido instalado exitosamente.</p>";
            echo "<a href='convivenciaEscolar.php' class='btn btn-primary'>Ir al Módulo</a>";
            echo "</div>";
            
            echo "</div>";
        } else {
            // Mostrar formulario de instalación
            ?>
            <div class="install-section">
                <h3>Información de Instalación</h3>
                <p>Este instalador configurará el módulo de Convivencia Escolar en su sistema. El proceso incluye:</p>
                <ul>
                    <li>Creación de la tabla en la base de datos</li>
                    <li>Configuración de índices para optimizar consultas</li>
                    <li>Creación de la estructura de carpetas necesaria</li>
                    <li>Configuración de permisos básicos</li>
                    <li>Verificación de archivos del módulo</li>
                </ul>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Importante:</strong> Asegúrese de tener permisos de administrador y haber realizado un respaldo de la base de datos antes de continuar.
                </div>
                
                <form method="POST">
                    <button type="submit" name="instalar" class="btn btn-primary btn-lg">
                        <i class="fas fa-rocket"></i> Instalar Módulo de Convivencia Escolar
                    </button>
                </form>
            </div>
            
            <div class="install-section">
                <h3>Requisitos del Sistema</h3>
                <ul>
                    <li>PHP 7.4 o superior</li>
                    <li>MySQL 5.7 o superior</li>
                    <li>Extensión mbstring habilitada</li>
                    <li>Extensión fileinfo habilitada</li>
                    <li>Permisos de escritura en el directorio del proyecto</li>
                </ul>
            </div>
            
            <div class="install-section">
                <h3>Verificación Previa</h3>
                <?php
                echo "<p><strong>Usuario actual:</strong> " . ($_SESSION['nombre'] ?? 'No definido') . "</p>";
                echo "<p><strong>ID Colegio:</strong> " . ($_SESSION['id_cole'] ?? 'No definido') . "</p>";
                echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
                
                // Verificar conexión a BD
                if ($mysqli->ping()) {
                    echo "<p class='success'><i class='fas fa-check'></i> Conexión a base de datos: OK</p>";
                } else {
                    echo "<p class='error'><i class='fas fa-times'></i> Conexión a base de datos: ERROR</p>";
                }
                
                // Verificar tabla colegios
                $result = $mysqli->query("SHOW TABLES LIKE 'colegios'");
                if ($result->num_rows > 0) {
                    echo "<p class='success'><i class='fas fa-check'></i> Tabla 'colegios' existe</p>";
                } else {
                    echo "<p class='error'><i class='fas fa-times'></i> Tabla 'colegios' no encontrada</p>";
                }
                ?>
            </div>
            <?php
        }
        ?>
        
        <div class="text-center mt-4">
            <a href="../../index.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Regresar al Inicio
            </a>
        </div>
    </div>
</body>
</html>
