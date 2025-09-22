<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Instalador Intensidad Horaria</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; padding: 10px; border: 1px solid green; background: #f0fff0; margin: 10px 0; }
        .error { color: red; padding: 10px; border: 1px solid red; background: #fff0f0; margin: 10px 0; }
        .info { color: blue; padding: 10px; border: 1px solid blue; background: #f0f0ff; margin: 10px 0; }
    </style>
</head>
<body>";

echo "<h2>Instalador del Sistema de Intensidad Horaria Semanal</h2>";

// Verificar si las tablas existen
$tablas_check = [
    'intensidad_horaria_semanal' => "SHOW TABLES LIKE 'intensidad_horaria_semanal'",
    'areas_asignaturas_config' => "SHOW TABLES LIKE 'areas_asignaturas_config'"
];

$crear_tablas = false;

foreach ($tablas_check as $tabla => $sql) {
    $result = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($result) == 0) {
        echo "<div class='info'>La tabla '$tabla' no existe. Se creará...</div>";
        $crear_tablas = true;
    } else {
        echo "<div class='success'>La tabla '$tabla' ya existe.</div>";
    }
}

if ($crear_tablas || isset($_GET['force'])) {
    echo "<h3>Creando tablas...</h3>";
    
    // Crear tabla intensidad_horaria_semanal
    $sql_intensidad = "CREATE TABLE IF NOT EXISTS intensidad_horaria_semanal (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cod_dane_sede VARCHAR(20) NOT NULL,
        nit_establecimiento VARCHAR(20),
        nombre_establecimiento VARCHAR(255),
        area VARCHAR(100) NOT NULL,
        asignatura VARCHAR(100) NOT NULL,
        grado_1 DECIMAL(4,2) DEFAULT 0,
        grado_2 DECIMAL(4,2) DEFAULT 0,
        grado_3 DECIMAL(4,2) DEFAULT 0,
        grado_4 DECIMAL(4,2) DEFAULT 0,
        grado_5 DECIMAL(4,2) DEFAULT 0,
        grado_6 DECIMAL(4,2) DEFAULT 0,
        grado_7 DECIMAL(4,2) DEFAULT 0,
        grado_8 DECIMAL(4,2) DEFAULT 0,
        grado_9 DECIMAL(4,2) DEFAULT 0,
        grado_10 DECIMAL(4,2) DEFAULT 0,
        grado_11 DECIMAL(4,2) DEFAULT 0,
        total_horas DECIMAL(5,2) DEFAULT 0,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_cod_dane_sede (cod_dane_sede),
        INDEX idx_area (area),
        INDEX idx_asignatura (asignatura),
        UNIQUE KEY unique_sede_area_asignatura (cod_dane_sede, area, asignatura)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if (mysqli_query($mysqli, $sql_intensidad)) {
        echo "<div class='success'>Tabla 'intensidad_horaria_semanal' creada exitosamente.</div>";
    } else {
        echo "<div class='error'>Error creando tabla 'intensidad_horaria_semanal': " . mysqli_error($mysqli) . "</div>";
    }
    
    // Crear tabla areas_asignaturas_config
    $sql_areas = "CREATE TABLE IF NOT EXISTS areas_asignaturas_config (
        id INT AUTO_INCREMENT PRIMARY KEY,
        area VARCHAR(100) NOT NULL,
        asignatura VARCHAR(100) NOT NULL,
        activa TINYINT(1) DEFAULT 1,
        orden_area INT DEFAULT 0,
        orden_asignatura INT DEFAULT 0,
        UNIQUE KEY unique_area_asignatura (area, asignatura)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if (mysqli_query($mysqli, $sql_areas)) {
        echo "<div class='success'>Tabla 'areas_asignaturas_config' creada exitosamente.</div>";
    } else {
        echo "<div class='error'>Error creando tabla 'areas_asignaturas_config': " . mysqli_error($mysqli) . "</div>";
    }
    
    // Insertar datos de configuración
    echo "<h3>Insertando datos de configuración...</h3>";
    
    $areas_asignaturas = [
        // CIENCIAS NATURALES
        ['CIENCIAS NATURALES', 'BIOLOGIA', 1, 1],
        ['CIENCIAS NATURALES', 'AMBIENTAL', 1, 2],
        ['CIENCIAS NATURALES', 'QUIMICA', 1, 3],
        ['CIENCIAS NATURALES', 'FISICA', 1, 4],
        
        // CIENCIAS SOCIALES
        ['CIENCIAS SOCIALES', 'HISTORIA DE COLOMBIA', 2, 1],
        ['CIENCIAS SOCIALES', 'DEMOCRACIA', 2, 2],
        ['CIENCIAS SOCIALES', 'CONSTITUCION POLITICA', 2, 3],
        ['CIENCIAS SOCIALES', 'CATEDRA DE LA PAZ', 2, 4],
        ['CIENCIAS SOCIALES', 'AFROCOLOMBIANIDAD', 2, 5],
        ['CIENCIAS SOCIALES', 'CONVIVENCIA', 2, 6],
        
        // EDUCACION ARTISTICA
        ['EDUCACION ARTISTICA', 'EDUCACION ARTISTICA', 3, 1],
        
        // ETICA Y VALORES HUMANOS
        ['ETICA Y VALORES HUMANOS', 'ETICA Y VALORES HUMANOS', 4, 1],
        
        // EDUCACION RELIGIOSA
        ['EDUCACION RELIGIOSA', 'EDUCACION RELIGIOSA', 5, 1],
        
        // EDUCACION FISICA RECREACION Y DEPORTE
        ['EDUCACION FISICA RECREACION Y DEPORTE', 'EDUCACION FISICA RECREACION Y DEPORTE', 6, 1],
        
        // HUMANIDADES
        ['HUMANIDADES', 'LENGUA CASTELLANA', 7, 1],
        ['HUMANIDADES', 'IDIOMA EXTRANJERO', 7, 2],
        
        // MATEMATICAS
        ['MATEMATICAS', 'MATEMATICAS', 8, 1],
        ['MATEMATICAS', 'GEOMETRIA', 8, 2],
        ['MATEMATICAS', 'ESTADISTICA', 8, 3],
        
        // TECNOLOGIA E INFORMATICA
        ['TECNOLOGIA E INFORMATICA', 'TECNOLOGIA', 9, 1],
        ['TECNOLOGIA E INFORMATICA', 'INFORMATICA', 9, 2],
        
        // EMPRENDIMIENTO
        ['EMPRENDIMIENTO', 'EMPRENDIMIENTO', 10, 1],
        
        // AREAS DE LA MEDIA ACADEMICA
        ['AREAS DE LA MEDIA ACADEMICA', 'CIENCIAS POLITICAS Y ECONOMICAS', 11, 1],
        ['AREAS DE LA MEDIA ACADEMICA', 'FILOSOFIA', 11, 2],
        
        // MEDIA TECNICA AREAS DE LA ESPECIALIDAD
        ['MEDIA TECNICA AREAS DE LA ESPECIALIDAD', 'MEDIA TECNICA', 12, 1]
    ];
    
    $insertados = 0;
    $existentes = 0;
    
    foreach ($areas_asignaturas as $item) {
        $area = mysqli_real_escape_string($mysqli, $item[0]);
        $asignatura = mysqli_real_escape_string($mysqli, $item[1]);
        $orden_area = $item[2];
        $orden_asignatura = $item[3];
        
        $sql_insert = "INSERT INTO areas_asignaturas_config (area, asignatura, orden_area, orden_asignatura) 
                       VALUES ('$area', '$asignatura', $orden_area, $orden_asignatura)
                       ON DUPLICATE KEY UPDATE 
                       orden_area = VALUES(orden_area),
                       orden_asignatura = VALUES(orden_asignatura)";
        
        if (mysqli_query($mysqli, $sql_insert)) {
            if (mysqli_affected_rows($mysqli) > 0) {
                $insertados++;
            } else {
                $existentes++;
            }
        }
    }
    
    echo "<div class='success'>Configuración completada: $insertados nuevos registros insertados, $existentes ya existían.</div>";
    
} else {
    echo "<div class='info'>Las tablas ya existen. No es necesario crearlas.</div>";
}

echo "<h3>Verificación final:</h3>";

// Verificar datos en areas_asignaturas_config
$result_areas = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM areas_asignaturas_config");
$row_areas = mysqli_fetch_assoc($result_areas);
echo "<div class='info'>Total de áreas/asignaturas configuradas: " . $row_areas['total'] . "</div>";

// Mostrar áreas disponibles
$result_areas_list = mysqli_query($mysqli, "SELECT DISTINCT area FROM areas_asignaturas_config ORDER BY orden_area");
echo "<div class='info'><strong>Áreas disponibles:</strong><br>";
while ($area = mysqli_fetch_assoc($result_areas_list)) {
    echo "- " . $area['area'] . "<br>";
}
echo "</div>";

echo "<div class='success'><strong>¡Instalación completada!</strong></div>";
echo "<p><a href='intensidad_horaria.php'>Ir al Sistema de Intensidad Horaria</a></p>";
echo "<p><a href='../ie/showIe.php'>Volver al Menú Principal</a></p>";

echo "</body></html>";

mysqli_close($mysqli);
?>