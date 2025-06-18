<?php
include '../../conexion.php';

// Verificar si la tabla existe
$sql = "SHOW TABLES LIKE 'estrategia_ju'";
$result = $mysqli->query($sql);

if ($result->num_rows == 0) {
    echo "La tabla 'estrategia_ju' no existe. Creándola...<br>";
    
    // Crear la tabla
    $createTable = "CREATE TABLE estrategia_ju (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cod_dane_sede VARCHAR(20) NOT NULL,
        aliado VARCHAR(100),
        eje VARCHAR(100),
        dias INT DEFAULT 0,
        horas INT DEFAULT 0,
        jornada VARCHAR(50),
        cantidad_prejardin INT DEFAULT 0,
        cantidad_jardin INT DEFAULT 0,
        cantidad_transicion INT DEFAULT 0,
        cantidad_1 INT DEFAULT 0,
        cantidad_2 INT DEFAULT 0,
        cantidad_3 INT DEFAULT 0,
        cantidad_4 INT DEFAULT 0,
        cantidad_5 INT DEFAULT 0,
        cantidad_6 INT DEFAULT 0,
        cantidad_7 INT DEFAULT 0,
        cantidad_8 INT DEFAULT 0,
        cantidad_9 INT DEFAULT 0,
        cantidad_10 INT DEFAULT 0,
        cantidad_11 INT DEFAULT 0,
        total_estudiantes INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_sede (cod_dane_sede)
    )";
    
    if ($mysqli->query($createTable)) {
        echo "Tabla 'estrategia_ju' creada exitosamente.<br>";
    } else {
        echo "Error al crear la tabla: " . $mysqli->error . "<br>";
    }
} else {
    echo "La tabla 'estrategia_ju' ya existe.<br>";
}

// Verificar estructura de la tabla
$sql = "DESCRIBE estrategia_ju";
$result = $mysqli->query($sql);

echo "<h3>Estructura de la tabla:</h3>";
echo "<table border='1'>";
echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['Field'] . "</td>";
    echo "<td>" . $row['Type'] . "</td>";
    echo "<td>" . $row['Null'] . "</td>";
    echo "<td>" . $row['Key'] . "</td>";
    echo "<td>" . $row['Default'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Verificar datos existentes
$sql = "SELECT COUNT(*) as total FROM estrategia_ju";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
echo "<p>Registros en la tabla: " . $row['total'] . "</p>";

?>
