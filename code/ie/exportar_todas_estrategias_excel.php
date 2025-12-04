<?php
// Forzar codificación UTF-8
ini_set('default_charset', 'UTF-8');
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="todas_estrategias_ju_' . date('Y-m-d_H-i-s') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Agregar BOM para UTF-8
echo "\xEF\xBB\xBF";

include '../../conexion.php';

// Establecer charset para la conexión
mysqli_set_charset($mysqli, 'utf8');

// Consulta principal para obtener TODAS las instituciones con sus sedes (activas e inactivas)
// LEFT JOIN para incluir sedes sin estrategia
$query = "SELECT 
    c.id_cole,
    c.nombre_cole,
    c.cod_dane_cole,
    m.nombre_mun,
    s.cod_dane_sede,
    s.nombre_sede,
    s.estado as estado_sede,
    ej.aliado,
    ej.eje,
    ej.especificar_aliado,
    ej.dias,
    ej.horas,
    ej.jornada,
    COALESCE(ej.cantidad_prejardin, 0) as cantidad_prejardin,
    COALESCE(ej.cantidad_jardin, 0) as cantidad_jardin,
    COALESCE(ej.cantidad_transicion, 0) as cantidad_transicion,
    COALESCE(ej.cantidad_1, 0) as cantidad_1,
    COALESCE(ej.cantidad_2, 0) as cantidad_2,
    COALESCE(ej.cantidad_3, 0) as cantidad_3,
    COALESCE(ej.cantidad_4, 0) as cantidad_4,
    COALESCE(ej.cantidad_5, 0) as cantidad_5,
    COALESCE(ej.cantidad_6, 0) as cantidad_6,
    COALESCE(ej.cantidad_7, 0) as cantidad_7,
    COALESCE(ej.cantidad_8, 0) as cantidad_8,
    COALESCE(ej.cantidad_9, 0) as cantidad_9,
    COALESCE(ej.cantidad_10, 0) as cantidad_10,
    COALESCE(ej.cantidad_11, 0) as cantidad_11,
    COALESCE(ej.total_estudiantes, 0) as total_estudiantes
FROM colegios c
INNER JOIN municipios m ON c.id_mun = m.id_mun
INNER JOIN sedes s ON c.id_cole = s.id_cole
LEFT JOIN estrategia_ju ej ON s.cod_dane_sede = ej.cod_dane_sede
ORDER BY c.nombre_cole ASC, s.nombre_sede ASC, ej.aliado ASC, ej.eje ASC";

$result = $mysqli->query($query);

if (!$result) {
    echo "Error en la consulta: " . $mysqli->error;
    exit;
}

// Inicializar variables para totales
$totalGeneral = [
    'prejardin' => 0,
    'jardin' => 0,
    'transicion' => 0,
    '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
    '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0,
    'total_estudiantes' => 0
];

$totalesPorInstitucion = [];
$datos = [];
$totalInstituciones = 0;
$totalSedes = 0;
$totalSedesConEstrategia = 0;

// Procesar datos
while ($row = $result->fetch_assoc()) {
    $datos[] = $row;
    $totalSedes++;
    
    // Si tiene estrategia, sumar a los totales
    if (!empty($row['aliado']) && !empty($row['eje'])) {
        $totalSedesConEstrategia++;
        
        // Calcular totales generales
        $totalGeneral['prejardin'] += $row['cantidad_prejardin'];
        $totalGeneral['jardin'] += $row['cantidad_jardin'];
        $totalGeneral['transicion'] += $row['cantidad_transicion'];
        for ($i = 1; $i <= 11; $i++) {
            $totalGeneral[$i] += $row['cantidad_' . $i];
        }
        $totalGeneral['total_estudiantes'] += $row['total_estudiantes'];
        
        // Calcular totales por institución
        $nombreInst = $row['nombre_cole'];
        if (!isset($totalesPorInstitucion[$nombreInst])) {
            $totalesPorInstitucion[$nombreInst] = [
                'prejardin' => 0, 'jardin' => 0, 'transicion' => 0,
                '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
                '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0,
                'total_estudiantes' => 0
            ];
        }
        
        $totalesPorInstitucion[$nombreInst]['prejardin'] += $row['cantidad_prejardin'];
        $totalesPorInstitucion[$nombreInst]['jardin'] += $row['cantidad_jardin'];
        $totalesPorInstitucion[$nombreInst]['transicion'] += $row['cantidad_transicion'];
        for ($i = 1; $i <= 11; $i++) {
            $totalesPorInstitucion[$nombreInst][$i] += $row['cantidad_' . $i];
        }
        $totalesPorInstitucion[$nombreInst]['total_estudiantes'] += $row['total_estudiantes'];
    }
}

// Contar instituciones únicas
$institucionesUnicas = array_unique(array_column($datos, 'nombre_cole'));
$totalInstituciones = count($institucionesUnicas);

// Generar el HTML para Excel
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Todas las Estrategias Jornada Única</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
        }
        .header {
            background-color: #2E5894;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .total-row {
            background-color: #D9E2F3;
            font-weight: bold;
        }
        .institucion-header {
            background-color: #FFC000;
            font-weight: bold;
            text-align: left;
            font-size: 11px;
        }
        .sede-sin-estrategia {
            background-color: #FFE699;
            font-style: italic;
        }
        .sede-suspendida {
            background-color: #F4B084;
            font-style: italic;
        }
        .institucion-total {
            background-color: #E2EFDA;
            font-weight: bold;
        }
        .general-total {
            background-color: #FCE4D6;
            font-weight: bold;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            color: #2E5894;
        }
        .subtitle {
            font-size: 12px;
            text-align: center;
            margin-bottom: 15px;
            color: #666;
        }
        .info-section {
            font-size: 10px;
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .legend {
            font-size: 9px;
            margin-top: 10px;
            padding: 8px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
        }
        .legend-item {
            display: inline-block;
            margin-right: 15px;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="title">TODAS LAS ESTRATEGIAS JORNADA ÚNICA (J.U)</div>
    <div class="subtitle">Reporte Consolidado de Todas las Instituciones Educativas</div>
    <div class="subtitle">Fecha de Exportación: <?php echo date('d/m/Y H:i'); ?></div>
    
    <div class="legend">
        <strong>Leyenda:</strong>
        <span class="legend-item" style="background-color: #FFE699;">⚠️ Sin Estrategia</span>
        <span class="legend-item" style="background-color: #F4B084;">🔴 Sede Suspendida</span>
        <span class="legend-item" style="background-color: #E2EFDA;">✅ Total Institución</span>
    </div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2">Cód. DANE Colegio</th>
                <th rowspan="2">Institución Educativa</th>
                <th rowspan="2">Municipio</th>
                <th rowspan="2">Cód. DANE Sede</th>
                <th rowspan="2">Sede</th>
                <th rowspan="2">Estado Sede</th>
                <th rowspan="2">Aliado</th>
                <th rowspan="2">Eje Movilizador</th>
                <th colspan="3">Preescolar</th>
                <th colspan="11">Básica y Media</th>
                <th rowspan="2">Total Estudiantes</th>
            </tr>
            <tr>
                <th>Prejardín</th>
                <th>Jardín</th>
                <th>Transición</th>
                <th>1º</th>
                <th>2º</th>
                <th>3º</th>
                <th>4º</th>
                <th>5º</th>
                <th>6º</th>
                <th>7º</th>
                <th>8º</th>
                <th>9º</th>
                <th>10º</th>
                <th>11º</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $institucionActual = '';
            $totalesInstitucion = [
                'prejardin' => 0, 'jardin' => 0, 'transicion' => 0,
                '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
                '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0,
                'total_estudiantes' => 0
            ];
            
            foreach ($datos as $index => $row): 
                // Si cambia la institución, mostrar totales de la anterior
                if ($institucionActual !== '' && $institucionActual !== $row['nombre_cole']) {
                    ?>
                    <tr class="institucion-total">
                        <td colspan="8">TOTAL <?php echo htmlspecialchars($institucionActual); ?></td>
                        <td><?php echo $totalesInstitucion['prejardin']; ?></td>
                        <td><?php echo $totalesInstitucion['jardin']; ?></td>
                        <td><?php echo $totalesInstitucion['transicion']; ?></td>
                        <td><?php echo $totalesInstitucion['1']; ?></td>
                        <td><?php echo $totalesInstitucion['2']; ?></td>
                        <td><?php echo $totalesInstitucion['3']; ?></td>
                        <td><?php echo $totalesInstitucion['4']; ?></td>
                        <td><?php echo $totalesInstitucion['5']; ?></td>
                        <td><?php echo $totalesInstitucion['6']; ?></td>
                        <td><?php echo $totalesInstitucion['7']; ?></td>
                        <td><?php echo $totalesInstitucion['8']; ?></td>
                        <td><?php echo $totalesInstitucion['9']; ?></td>
                        <td><?php echo $totalesInstitucion['10']; ?></td>
                        <td><?php echo $totalesInstitucion['11']; ?></td>
                        <td><?php echo $totalesInstitucion['total_estudiantes']; ?></td>
                    </tr>
                    <tr><td colspan="23" style="height: 5px; background-color: #fff;"></td></tr>
                    <?php
                    // Reiniciar totales
                    $totalesInstitucion = array_fill_keys(array_keys($totalesInstitucion), 0);
                }
                
                $institucionActual = $row['nombre_cole'];
                
                // Determinar la clase CSS según el estado
                $rowClass = '';
                $estadoBadge = 'Activo';
                
                if (empty($row['aliado']) || empty($row['eje'])) {
                    $rowClass = 'sede-sin-estrategia';
                    $estadoBadge = 'Sin Estrategia';
                } elseif ($row['estado_sede'] === 'suspendido') {
                    $rowClass = 'sede-suspendida';
                    $estadoBadge = 'Suspendida';
                }
                
                // Acumular totales de la institución
                if (!empty($row['aliado']) && !empty($row['eje'])) {
                    $totalesInstitucion['prejardin'] += $row['cantidad_prejardin'];
                    $totalesInstitucion['jardin'] += $row['cantidad_jardin'];
                    $totalesInstitucion['transicion'] += $row['cantidad_transicion'];
                    for ($i = 1; $i <= 11; $i++) {
                        $totalesInstitucion[$i] += $row['cantidad_' . $i];
                    }
                    $totalesInstitucion['total_estudiantes'] += $row['total_estudiantes'];
                }
            ?>
                <tr class="<?php echo $rowClass; ?>">
                    <td style="mso-number-format:'\@';"><?php echo "'" . htmlspecialchars($row['cod_dane_cole']); ?></td>
                    <td style="text-align: left;"><?php echo htmlspecialchars($row['nombre_cole']); ?></td>
                    <td style="text-align: left;"><?php echo htmlspecialchars($row['nombre_mun']); ?></td>
                    <td style="mso-number-format:'\@';"><?php echo "'" . htmlspecialchars($row['cod_dane_sede']); ?></td>
                    <td style="text-align: left;"><?php echo htmlspecialchars($row['nombre_sede']); ?></td>
                    <td><?php echo $estadoBadge; ?></td>
                    <td><?php 
                        // Mostrar el aliado o "Sin Estrategia"
                        if (empty($row['aliado'])) {
                            echo '-';
                        } elseif ($row['aliado'] === 'Entre Otros' && !empty($row['especificar_aliado'])) {
                            echo htmlspecialchars($row['especificar_aliado']);
                        } else {
                            echo htmlspecialchars($row['aliado']);
                        }
                    ?></td>
                    <td><?php echo !empty($row['eje']) ? htmlspecialchars($row['eje']) : '-'; ?></td>
                    <td><?php echo intval($row['cantidad_prejardin']); ?></td>
                    <td><?php echo intval($row['cantidad_jardin']); ?></td>
                    <td><?php echo intval($row['cantidad_transicion']); ?></td>
                    <td><?php echo intval($row['cantidad_1']); ?></td>
                    <td><?php echo intval($row['cantidad_2']); ?></td>
                    <td><?php echo intval($row['cantidad_3']); ?></td>
                    <td><?php echo intval($row['cantidad_4']); ?></td>
                    <td><?php echo intval($row['cantidad_5']); ?></td>
                    <td><?php echo intval($row['cantidad_6']); ?></td>
                    <td><?php echo intval($row['cantidad_7']); ?></td>
                    <td><?php echo intval($row['cantidad_8']); ?></td>
                    <td><?php echo intval($row['cantidad_9']); ?></td>
                    <td><?php echo intval($row['cantidad_10']); ?></td>
                    <td><?php echo intval($row['cantidad_11']); ?></td>
                    <td class="total-row"><?php echo intval($row['total_estudiantes']); ?></td>
                </tr>
            <?php 
            endforeach;
            
            // Mostrar total de la última institución
            if ($institucionActual !== '') {
            ?>
                <tr class="institucion-total">
                    <td colspan="8">TOTAL <?php echo htmlspecialchars($institucionActual); ?></td>
                    <td><?php echo $totalesInstitucion['prejardin']; ?></td>
                    <td><?php echo $totalesInstitucion['jardin']; ?></td>
                    <td><?php echo $totalesInstitucion['transicion']; ?></td>
                    <td><?php echo $totalesInstitucion['1']; ?></td>
                    <td><?php echo $totalesInstitucion['2']; ?></td>
                    <td><?php echo $totalesInstitucion['3']; ?></td>
                    <td><?php echo $totalesInstitucion['4']; ?></td>
                    <td><?php echo $totalesInstitucion['5']; ?></td>
                    <td><?php echo $totalesInstitucion['6']; ?></td>
                    <td><?php echo $totalesInstitucion['7']; ?></td>
                    <td><?php echo $totalesInstitucion['8']; ?></td>
                    <td><?php echo $totalesInstitucion['9']; ?></td>
                    <td><?php echo $totalesInstitucion['10']; ?></td>
                    <td><?php echo $totalesInstitucion['11']; ?></td>
                    <td><?php echo $totalesInstitucion['total_estudiantes']; ?></td>
                </tr>
            <?php } ?>
            
            <!-- Fila de totales generales -->
            <tr><td colspan="23" style="height: 10px; background-color: #fff;"></td></tr>
            <tr class="general-total">
                <td colspan="8">TOTAL GENERAL (TODAS LAS INSTITUCIONES)</td>
                <td><?php echo $totalGeneral['prejardin']; ?></td>
                <td><?php echo $totalGeneral['jardin']; ?></td>
                <td><?php echo $totalGeneral['transicion']; ?></td>
                <td><?php echo $totalGeneral['1']; ?></td>
                <td><?php echo $totalGeneral['2']; ?></td>
                <td><?php echo $totalGeneral['3']; ?></td>
                <td><?php echo $totalGeneral['4']; ?></td>
                <td><?php echo $totalGeneral['5']; ?></td>
                <td><?php echo $totalGeneral['6']; ?></td>
                <td><?php echo $totalGeneral['7']; ?></td>
                <td><?php echo $totalGeneral['8']; ?></td>
                <td><?php echo $totalGeneral['9']; ?></td>
                <td><?php echo $totalGeneral['10']; ?></td>
                <td><?php echo $totalGeneral['11']; ?></td>
                <td><?php echo $totalGeneral['total_estudiantes']; ?></td>
            </tr>
        </tbody>
    </table>
    
    <br><br>
    <div class="info-section">
        <strong>📊 Estadísticas Generales Consolidadas:</strong><br>
        Total de Instituciones Educativas: <?php echo number_format($totalInstituciones); ?><br>
        Total de Sedes: <?php echo number_format($totalSedes); ?><br>
        Total de Sedes con Estrategia J.U: <?php echo number_format($totalSedesConEstrategia); ?><br>
        Total de Sedes sin Estrategia: <?php echo number_format($totalSedes - $totalSedesConEstrategia); ?><br>
        Total de Estudiantes Beneficiados: <?php echo number_format($totalGeneral['total_estudiantes']); ?><br>
        Fecha de Generación: <?php echo date('d/m/Y H:i:s'); ?><br>
        Generado por: Sistema PEI<br>
        <br>
        <em>📝 Nota: Este reporte incluye TODAS las instituciones educativas y todas sus sedes (activas, suspendidas y sin estrategia)</em>
    </div>
</body>
</html>
