<?php
// Forzar codificación UTF-8
ini_set('default_charset', 'UTF-8');
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="estrategia_ju_' . date('Y-m-d_H-i-s') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Agregar BOM para UTF-8
echo "\xEF\xBB\xBF";

include '../../conexion.php';

// Establecer charset para la conexión
mysqli_set_charset($mysqli, 'utf8');

// Obtener el ID del colegio desde la URL
$id_cole = $_GET['id_cole'] ?? '';

if (empty($id_cole)) {
    echo "Error: No se especificó el ID del colegio.";
    exit;
}

// Obtener información del colegio
$queryColegios = "SELECT nombre_cole FROM colegios WHERE id_cole = ?";
$stmtColegios = $mysqli->prepare($queryColegios);
$stmtColegios->bind_param("i", $id_cole);
$stmtColegios->execute();
$resultColegios = $stmtColegios->get_result();
$colegio = $resultColegios->fetch_assoc();

if (!$colegio) {
    echo "Error: No se encontró el colegio especificado.";
    exit;
}

// Consulta principal para obtener los datos de la estrategia J.U (solo sedes activas)
$query = "SELECT 
    s.cod_dane_sede,
    s.nombre_sede,
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
FROM sedes s
INNER JOIN estrategia_ju ej ON s.cod_dane_sede = ej.cod_dane_sede
WHERE s.id_cole = ? 
    AND (s.estado IS NULL OR s.estado = 'activo')
ORDER BY s.nombre_sede ASC, ej.aliado ASC, ej.eje ASC";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_cole);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar variables para totales
$totalGeneral = [
    'prejardin' => 0,
    'jardin' => 0,
    'transicion' => 0,
    '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
    '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0,
    'total_estudiantes' => 0
];

$totalesPorSede = [];
$datos = [];

// Procesar datos
while ($row = $result->fetch_assoc()) {
    $datos[] = $row;
    
    // Calcular totales generales
    $totalGeneral['prejardin'] += $row['cantidad_prejardin'];
    $totalGeneral['jardin'] += $row['cantidad_jardin'];
    $totalGeneral['transicion'] += $row['cantidad_transicion'];
    for ($i = 1; $i <= 11; $i++) {
        $totalGeneral[$i] += $row['cantidad_' . $i];
    }
    $totalGeneral['total_estudiantes'] += $row['total_estudiantes'];
    
    // Calcular totales por sede
    $sede = $row['nombre_sede'];
    if (!isset($totalesPorSede[$sede])) {
        $totalesPorSede[$sede] = [
            'prejardin' => 0, 'jardin' => 0, 'transicion' => 0,
            '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
            '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0,
            'total_estudiantes' => 0
        ];
    }
    
    $totalesPorSede[$sede]['prejardin'] += $row['cantidad_prejardin'];
    $totalesPorSede[$sede]['jardin'] += $row['cantidad_jardin'];
    $totalesPorSede[$sede]['transicion'] += $row['cantidad_transicion'];
    for ($i = 1; $i <= 11; $i++) {
        $totalesPorSede[$sede][$i] += $row['cantidad_' . $i];
    }
    $totalesPorSede[$sede]['total_estudiantes'] += $row['total_estudiantes'];
}

// Generar el HTML para Excel
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estrategia Jornada Única - <?php echo htmlspecialchars($colegio['nombre_cole']); ?></title>
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
        .sede-total {
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
    </style>
</head>
<body>
    <div class="title">ESTRATEGIA JORNADA ÚNICA (J.U)</div>
    <div class="subtitle"><?php echo htmlspecialchars($colegio['nombre_cole']); ?></div>
    <div class="subtitle">Fecha de Exportación: <?php echo date('d/m/Y H:i'); ?></div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2">Cód. DANE</th>
                <th rowspan="2">Sede</th>
                <th rowspan="2">Aliado</th>
                <th rowspan="2">Eje Movilizador</th>
                <th colspan="4">Preescolar</th>
                <th colspan="11">Básica y Media</th>
                <th rowspan="2">Total Estudiantes</th>
            </tr>
            <tr>
                <th>Prejardín</th>
                <th>Jardín</th>
                <th>Transición</th>
                <th>Total Preesco</th>
                <th>1-</th>
                <th>2-</th>
                <th>3-</th>
                <th>4-</th>
                <th>5-</th>
                <th>6-</th>
                <th>7-</th>
                <th>8-</th>
                <th>9-</th>
                <th>10-</th>
                <th>11-</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($datos) > 0): ?>
                <?php foreach ($datos as $row): ?>
                    <tr>
                        <td style="mso-number-format:'\@';"><?php echo "'" . htmlspecialchars($row['cod_dane_sede']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_sede']); ?></td>
                        <td><?php 
                            // Mostrar el aliado, si es "Entre Otros" y hay especificación, mostrarla
                            if ($row['aliado'] === 'Entre Otros' && !empty($row['especificar_aliado'])) {
                                echo htmlspecialchars($row['especificar_aliado']);
                            } else {
                                echo htmlspecialchars($row['aliado']);
                            }
                        ?></td>
                        <td><?php echo htmlspecialchars($row['eje']); ?></td>
                        <td><?php echo intval($row['cantidad_prejardin']); ?></td>
                        <td><?php echo intval($row['cantidad_jardin']); ?></td>
                        <td><?php echo intval($row['cantidad_transicion']); ?></td>
                        <td><?php echo intval($row['cantidad_prejardin']) + intval($row['cantidad_jardin']) + intval($row['cantidad_transicion']); ?></td>
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
                <?php endforeach; ?>
                
                <!-- Fila de totales generales -->
                <tr class="general-total">
                    <td colspan="4">TOTAL GENERAL</td>
                    <td><?php echo $totalGeneral['prejardin']; ?></td>
                    <td><?php echo $totalGeneral['jardin']; ?></td>
                    <td><?php echo $totalGeneral['transicion']; ?></td>
                    <td><?php echo $totalGeneral['prejardin'] + $totalGeneral['jardin'] + $totalGeneral['transicion']; ?></td>
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
            <?php else: ?>
                <tr>
                    <td colspan="19">No hay datos de estrategia J.U registrados para esta institución.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php if (count($totalesPorSede) > 0): ?>
        <br><br>
        <div class="title">RESUMEN POR SEDE (SOLO SEDES ACTIVAS)</div>
        <table>
            <thead>
                <tr>
                    <th>Sede</th>
                    <th>Prejardín</th>
                    <th>Jardín</th>
                    <th>Transición</th>
                    <th>Total Preesco</th>
                    <th>1-</th>
                    <th>2-</th>
                    <th>3-</th>
                    <th>4-</th>
                    <th>5-</th>
                    <th>6-</th>
                    <th>7-</th>
                    <th>8-</th>
                    <th>9-</th>
                    <th>10-</th>
                    <th>11-</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($totalesPorSede as $sede => $totales): ?>
                    <tr class="sede-total">
                        <td><?php echo htmlspecialchars($sede); ?></td>
                        <td><?php echo $totales['prejardin']; ?></td>
                        <td><?php echo $totales['jardin']; ?></td>
                        <td><?php echo $totales['transicion']; ?></td>
                        <td><?php echo $totales['prejardin'] + $totales['jardin'] + $totales['transicion']; ?></td>
                        <td><?php echo $totales['1']; ?></td>
                        <td><?php echo $totales['2']; ?></td>
                        <td><?php echo $totales['3']; ?></td>
                        <td><?php echo $totales['4']; ?></td>
                        <td><?php echo $totales['5']; ?></td>
                        <td><?php echo $totales['6']; ?></td>
                        <td><?php echo $totales['7']; ?></td>
                        <td><?php echo $totales['8']; ?></td>
                        <td><?php echo $totales['9']; ?></td>
                        <td><?php echo $totales['10']; ?></td>
                        <td><?php echo $totales['11']; ?></td>
                        <td><?php echo $totales['total_estudiantes']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <br><br>
    <div class="info-section">
        <strong>Estadísticas Generales (Solo Sedes Activas):</strong><br>
        Total de Registros de Estrategia J.U: <?php echo count($datos); ?><br>
        Total de Sedes Activas con Estrategia J.U: <?php echo count($totalesPorSede); ?><br>
        Total de Estudiantes Beneficiados: <?php echo number_format($totalGeneral['total_estudiantes']); ?><br>
        Fecha de Generación: <?php echo date('d/m/Y H:i:s'); ?><br>
        Generado por: Sistema PEI<br>
        <em>Nota: Este reporte excluye las sedes suspendidas</em>
    </div>
</body>
</html>
