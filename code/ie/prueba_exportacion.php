<?php
// Archivo de prueba para verificar la funcionalidad de exportación
include '../../conexion.php';
mysqli_set_charset($mysqli, 'utf8');

// Simular un ID de colegio para prueba
$id_cole = 1; // Cambia este valor por un ID válido de tu base de datos

// Verificar que existe el colegio
$queryColegios = "SELECT * FROM colegios WHERE id_cole = ?";
$stmtColegios = $mysqli->prepare($queryColegios);
$stmtColegios->bind_param("i", $id_cole);
$stmtColegios->execute();
$resultColegios = $stmtColegios->get_result();

echo "<h2>Prueba de Exportación de Estrategia J.U</h2>";
echo "<hr>";

if ($resultColegios->num_rows > 0) {
    $colegio = $resultColegios->fetch_assoc();
    echo "<h3>Colegio encontrado:</h3>";
    echo "<p><strong>ID:</strong> " . $colegio['id_cole'] . "</p>";
    echo "<p><strong>Nombre:</strong> " . $colegio['nombre_cole'] . "</p>";
    echo "<p><strong>DANE:</strong> " . $colegio['cod_dane_cole'] . "</p>";
    echo "<hr>";
    
    // Verificar sedes
    $querySedes = "SELECT * FROM sedes WHERE id_cole = ?";
    $stmtSedes = $mysqli->prepare($querySedes);
    $stmtSedes->bind_param("i", $id_cole);
    $stmtSedes->execute();
    $resultSedes = $stmtSedes->get_result();
    
    echo "<h3>Sedes encontradas:</h3>";
    if ($resultSedes->num_rows > 0) {
        echo "<ul>";
        while ($sede = $resultSedes->fetch_assoc()) {
            echo "<li>" . $sede['nombre_sede'] . " (DANE: " . $sede['cod_dane_sede'] . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No se encontraron sedes para este colegio.</p>";
    }
    echo "<hr>";
    
    // Verificar datos de estrategia J.U
    $queryEstrategia = "SELECT 
        s.cod_dane_sede,
        s.nombre_sede,
        ej.aliado,
        ej.eje,
        ej.especificar_aliado,
        ej.total_estudiantes
    FROM sedes s
    INNER JOIN estrategia_ju ej ON s.cod_dane_sede = ej.cod_dane_sede
    WHERE s.id_cole = ?
    ORDER BY s.nombre_sede ASC";
    
    $stmtEstrategia = $mysqli->prepare($queryEstrategia);
    $stmtEstrategia->bind_param("i", $id_cole);
    $stmtEstrategia->execute();
    $resultEstrategia = $stmtEstrategia->get_result();
    
    echo "<h3>Datos de Estrategia J.U encontrados:</h3>";
    if ($resultEstrategia->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>Sede</th>
                <th>DANE</th>
                <th>Aliado</th>
                <th>Eje</th>
                <th>Total Estudiantes</th>
              </tr>";
        
        $totalGeneral = 0;
        while ($row = $resultEstrategia->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nombre_sede']) . "</td>";
            echo "<td>" . htmlspecialchars($row['cod_dane_sede']) . "</td>";
            echo "<td>" . htmlspecialchars($row['aliado'] === 'Entre Otros' && !empty($row['especificar_aliado']) ? $row['especificar_aliado'] : $row['aliado']) . "</td>";
            echo "<td>" . htmlspecialchars($row['eje']) . "</td>";
            echo "<td>" . $row['total_estudiantes'] . "</td>";
            echo "</tr>";
            $totalGeneral += $row['total_estudiantes'];
        }
        
        echo "<tr style='background-color: #f0f0f0; font-weight: bold;'>";
        echo "<td colspan='4'>TOTAL GENERAL</td>";
        echo "<td>" . $totalGeneral . "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<br><p><strong>Archivos de exportación disponibles:</strong></p>";
        echo "<ul>";
        echo "<li><a href='exportar_estrategia_excel.php?id_cole=" . $id_cole . "' target='_blank'>Exportar a Excel</a></li>";
        echo "</ul>";
        
    } else {
        echo "<p>No se encontraron datos de estrategia J.U para este colegio.</p>";
        echo "<p><em>Nota: Asegúrate de que existen registros en la tabla 'estrategia_ju' para las sedes de este colegio.</em></p>";
    }
    
} else {
    echo "<p style='color: red;'>No se encontró el colegio con ID: $id_cole</p>";
    echo "<p>Por favor, verifica que el ID del colegio sea correcto.</p>";
    
    // Mostrar colegios disponibles
    $queryTodosColegios = "SELECT id_cole, nombre_cole FROM colegios LIMIT 10";
    $resultTodosColegios = $mysqli->query($queryTodosColegios);
    
    if ($resultTodosColegios->num_rows > 0) {
        echo "<h3>Colegios disponibles (primeros 10):</h3>";
        echo "<ul>";
        while ($colegio = $resultTodosColegios->fetch_assoc()) {
            echo "<li>ID: " . $colegio['id_cole'] . " - " . $colegio['nombre_cole'] . "</li>";
        }
        echo "</ul>";
    }
}

echo "<hr>";
echo "<p><small>Archivo de prueba generado el: " . date('d/m/Y H:i:s') . "</small></p>";
?>
