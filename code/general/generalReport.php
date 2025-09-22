<?php
include("./../../conexion.php");
include("./../../sessionCheck.php");
include("./teologico.php");
include("./mallas.php");
include("./siee.php");
include("./transversal.php");
include("./proyectoPlanes.php");
include("./educacionInicial.php");
include("./planAula.php");
include("./integral.php");
include("./ie.php");
include("./proyectoPedagogico.php");
include("./observacion.php");
include("./convivencia.php");
include("./evidencias.php");
include("./intensidadHoraria.php");



        /* Ajustes para mostrar más columnas y habilitar scroll horizontal */

$consulta = "SELECT * FROM colegios";

if (isset($_POST['filtrar'])) {
    $filtro = $_POST['filtro'];
    $consulta = "SELECT * FROM colegios WHERE nombre_cole LIKE '%$filtro%' OR id_cole = '$filtro'";
}

$resultados = mysqli_query($mysqli, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe General PEI - Sistema de Gestión Educativa</title>
    <link rel="stylesheet" href="./../../css/generalReport.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* Variables CSS para consistencia */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        /* Mejorar estilos base */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            margin: 0;
            padding: 20px;
        }

        /* Contenedor moderno */
        .container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 30px;
            margin: 0 auto;
        /* Reducir padding y tamaño de fuente para celdas generales */
            width: 100%; /* Usar todo el ancho disponible */
            max-width: none; /* Permitir extender más allá de 1400px si es necesario */
        }

        /* Mejorar formularios */
        form {
            background: var(--light-color);
            padding: 25px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            text-align: center;
        }

        h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        input[type="text"] {
            padding: 12px 16px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            min-width: 300px;
            transition: var(--transition);
            margin-right: 10px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        input[type="submit"] {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Mejorar tabla - Visualización completa y separaciones claras */
        .table-container {
            width: 100%;
            overflow-x: auto;
            background: transparent;
            border-radius: 0;
            box-shadow: none;
            padding: 10px 0; /* espacio vertical sin limitar ancho */
            margin: 20px 0 0 0;
            border-left: none;
            border-right: none;
        }

        table {
            width: 100%;
            min-width: max-content; /* Ajustar al contenido para mostrar todas las columnas */
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            font-size: 0.9rem;
            table-layout: auto; /* Dejar que columnas ajusten su ancho según contenido */
        }

        /* Encabezados con mejor separación (no sticky por defecto)
           Para habilitar sticky, agregue la clase .sticky a .table-container */
        thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
        }

        /* Nuevas clases para headers obligatoriamente sticky - Diseño moderno */
        .table-headers-sticky {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, #1a252f, #2c3e50, #34495e);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-bottom: 3px solid var(--secondary-color);
        }

        .table-headers-sticky tr:first-child {
            position: sticky;
            top: 0;
            z-index: 102;
            background: linear-gradient(135deg, #1a252f 0%, #2c3e50 50%, #34495e 100%);
        }

        .table-headers-sticky tr:nth-child(2) {
            position: sticky;
            top: 60px; /* Altura ajustada para la primera fila */
            z-index: 101;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #445566 100%);
            border-top: 2px solid rgba(255,255,255,0.1);
        }

        .table-headers-sticky th {
            padding: 12px 8px;
            text-align: center;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-right: 2px solid rgba(255,255,255,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            white-space: nowrap;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.05) 50%, transparent 100%);
        }

        .table-headers-sticky th:hover {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.1) 100%);
            transform: translateY(-1px);
        }

        .table-headers-sticky th:last-child {
            border-right: none;
        }

        /* Encabezados de categoría con colores distintivos */
        .table-headers-sticky .encabezado1 { 
            border-bottom: 4px solid #3498db; 
            background: linear-gradient(135deg, rgba(52,152,219,0.2), rgba(52,152,219,0.1));
        }
        .table-headers-sticky .encabezado2 { 
            border-bottom: 4px solid #e74c3c; 
            background: linear-gradient(135deg, rgba(231,76,60,0.2), rgba(231,76,60,0.1));
        }
        .table-headers-sticky .encabezado3 { 
            border-bottom: 4px solid #f39c12; 
            background: linear-gradient(135deg, rgba(243,156,18,0.2), rgba(243,156,18,0.1));
        }
        .table-headers-sticky .encabezado4 { 
            border-bottom: 4px solid #9b59b6; 
            background: linear-gradient(135deg, rgba(155,89,182,0.2), rgba(155,89,182,0.1));
        }
        .table-headers-sticky .encabezado5 { 
            border-bottom: 4px solid #1abc9c; 
            background: linear-gradient(135deg, rgba(26,188,156,0.2), rgba(26,188,156,0.1));
        }
        .table-headers-sticky .encabezado6 { 
            border-bottom: 4px solid #34495e; 
            background: linear-gradient(135deg, rgba(52,73,94,0.2), rgba(52,73,94,0.1));
        }

        /* Sticky headers (opcional) */
        .table-container.sticky-headers thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-container.sticky-headers thead tr:first-child th {
            position: sticky;
            top: 0;
            z-index: 11;
        }

        .table-container.sticky-headers thead tr:nth-child(2) th {
            position: sticky;
            top: 56px; /* adjust if needed */
            z-index: 10;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        th {
            padding: 15px 12px;
            text-align: center;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-right: 2px solid rgba(255,255,255,0.2);
            border-bottom: 2px solid rgba(255,255,255,0.3);
            white-space: nowrap;
        }

        th:last-child {
            border-right: none;
        }

        /* Filas del cuerpo con separaciones claras */
        tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #dee2e6;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tbody tr:hover {
            background-color: #e3f2fd !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: var(--transition);
        }

        /* Celdas con bordes claros */
        td {
            padding: 12px 10px;
            text-align: center;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
            white-space: nowrap;
            min-width: 80px;
        }

        td:last-child {
            border-right: none;
        }

        /* Celdas especiales */
        td.observacion {
            min-width: 200px;
            max-width: 300px;
            white-space: normal;
            text-align: left;
        }

        /* Estados mejorados con bordes */
        .verde {
            background-color: #d4edda !important;
            color: #155724;
            font-weight: 600;
            border-left: 4px solid #28a745;
        }

        .rojo {
            background-color: #f8d7da !important;
            color: #721c24;
            font-weight: 600;
            border-left: 4px solid #dc3545;
        }

        /* Scroll personalizado para la tabla */
        .table-container::-webkit-scrollbar {
            height: 12px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 6px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 6px;
            border: 2px solid #f1f1f1;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
        }

        /* Indicador de scroll */
        .scroll-indicator {
            position: relative;
            text-align: center;
            padding: 8px 12px;
            background: linear-gradient(90deg, rgba(227,242,253,0.95), rgba(187,222,251,0.95));
            color: var(--primary-color);
            font-weight: 600;
            border-top: 2px solid var(--secondary-color);
            margin-top: 6px;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        /* Botones modernos */
        .back button, .button {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .back button:hover, .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .button a {
            color: var(--white);
            text-decoration: none;
        }

        /* Checkbox moderno */
        .detalles {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detalles label {
            background: var(--warning-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        .detalles label:hover {
            background: #e67e22;
        }

        .detalles input[type="checkbox"]:checked + label {
            background: var(--success-color);
        }

        /* Observaciones mejoradas */
        .td-textarea {
            width: 100%;
            min-height: 80px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            padding: 10px;
            font-family: inherit;
            resize: vertical;
            transition: var(--transition);
        }

        .td-textarea:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        .buton-observacion {
            background: var(--secondary-color);
            color: var(--white);
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            margin-top: 8px;
            transition: var(--transition);
        }

        .buton-observacion:hover {
            background: #2980b9;
            transform: translateY(-1px);
        }

        /* Botones de acción */
        .botones {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        /* Corner button moderno */
        .corner-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
            color: var(--white);
            padding: 12px 20px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            box-shadow: var(--shadow);
            transition: var(--transition);
            z-index: 1000;
        }

        .corner-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            color: var(--white);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 10px;
            }

            input[type="text"] {
                min-width: 100%;
                margin-bottom: 10px;
            }

            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 8px 5px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* Variables CSS para consistencia */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        /* Reset y estilos base modernos */
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            min-height: 100vh;
        }

        /* Contenedor principal moderno */
        .modern-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 30px;
            margin: 0 auto;
            width: 100%;
            max-width: none;
        }

        /* Header mejorado */
        .header-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: var(--border-radius);
            color: var(--white);
        }

        .header-section h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header-section .subtitle {
            margin: 10px 0 0 0;
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Botones superiores modernos */
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .corner-button-modern {
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
            color: var(--white);
            padding: 12px 20px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .corner-button-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            color: var(--white);
        }

        /* Formulario de búsqueda moderno */
        .search-form {
            background: var(--light-color);
            padding: 25px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }

        .search-form h2 {
            margin: 0 0 20px 0;
            color: var(--primary-color);
            font-size: 1.8rem;
            text-align: center;
        }

        .search-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .modern-input {
            padding: 12px 16px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            min-width: 300px;
            transition: var(--transition);
        }

        .modern-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .modern-btn {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Controles y filtros modernos */
        .controls-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: var(--light-color);
            border-radius: var(--border-radius);
            flex-wrap: wrap;
            gap: 15px;
        }

        .checkbox-modern {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 500;
        }

        .checkbox-modern input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--secondary-color);
        }

        .btn-excel {
            background: linear-gradient(135deg, var(--success-color), #2ecc71);
            color: var(--white);
            padding: 10px 20px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .btn-excel:hover {
            transform: translateY(-2px);
            color: var(--white);
        }

        /* Tabla moderna y responsive */
        .table-container {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: inherit;
        }

        thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        th {
            padding: 15px 10px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e3f2fd;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        td {
            padding: 12px 10px;
            text-align: center;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* Estados de las celdas */
        .verde {
            background-color: #d4edda !important;
            color: #155724;
            font-weight: 600;
        }

        .rojo {
            background-color: #f8d7da !important;
            color: #721c24;
            font-weight: 600;
        }

        /* Encabezados de categorías */
        .encabezado {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .encabezado1 { border-bottom: 3px solid #3498db; }
        .encabezado2 { border-bottom: 3px solid #e74c3c; }
        .encabezado3 { border-bottom: 3px solid #f39c12; }
        .encabezado4 { border-bottom: 3px solid #9b59b6; }
        .encabezado5 { border-bottom: 3px solid #1abc9c; }
        .encabezado6 { border-bottom: 3px solid #34495e; }

        /* Botón regresar moderno */
        .back-button {
            text-align: center;
            margin-top: 30px;
        }

        .back-button button {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: var(--white);
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .back-button button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Observaciones mejoradas */
        .observacion-form {
            padding: 15px;
            background: #f8f9fa;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--secondary-color);
        }

        .td-textarea {
            width: 100%;
            min-height: 80px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            padding: 10px;
            font-family: inherit;
            resize: vertical;
            transition: var(--transition);
        }

        .td-textarea:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        .buton-observacion {
            background: var(--secondary-color);
            color: var(--white);
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            margin-top: 8px;
            transition: var(--transition);
        }

        .buton-observacion:hover {
            background: #2980b9;
        }

        /* Notificaciones y alertas mejoradas */
        .alert {
            animation: slideInRight 0.3s ease-out;
            font-weight: 500;
            border: none;
            max-width: 400px;
        }

        .alert-success {
            background: linear-gradient(135deg, var(--success-color), #27d665) !important;
        }

        .alert-error {
            background: linear-gradient(135deg, var(--danger-color), #ff4757) !important;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Controles mejorados */
        .controls-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: var(--shadow);
        }

        .checkbox-modern {
            background: rgba(255,255,255,0.2);
            padding: 0.75rem 1.25rem;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .checkbox-modern:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .checkbox-modern input[type="checkbox"] {
            margin-right: 0.5rem;
            transform: scale(1.2);
        }

        .btn-excel {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-excel:hover {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Animaciones para tabla */
        .table-container table {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design mejorado para tabla */
        @media (max-width: 768px) {
            .modern-container {
                padding: 15px;
            }

            .header-section h1 {
                font-size: 2rem;
            }

            .search-group {
                flex-direction: column;
            }

            .modern-input {
                min-width: 100%;
            }

            .controls-section {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-info .legend-item {
                display: block;
                margin: 0.5rem 0;
            }
            
            .main-container {
                padding: 1rem;
            }

            /* Tabla responsive */
            .table-container {
                margin: 10px -15px;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            table {
                min-width: 1000px;
                font-size: 0.8rem;
            }

            th {
                padding: 10px 8px;
                font-size: 0.75rem;
            }

            td {
                padding: 8px 6px;
                min-width: 60px;
            }

            td.observacion {
                min-width: 150px;
                max-width: 200px;
            }
        }

        /* Footer informativo mejorado */
        .footer-info {
            background: linear-gradient(135deg, var(--light-color), #f8f9fa);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            margin-top: 2rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .footer-info .legend-item {
            display: inline-block;
            margin: 0 1rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
            font-weight: 600;
        }

        .footer-info .legend-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

            .controls-section {
                flex-direction: column;
                text-align: center;
            }

            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 8px 5px;
            }
        

        /* Animaciones suaves */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-container {
            animation: fadeIn 0.5s ease-out;
        }

        /* Enlaces mejorados */
        a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        tr:hover a {
            color: var(--primary-color);
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="modern-container">
        <!-- Header principal -->
        <div class="header-section">
            <h1><i class="fas fa-chart-line"></i> Informe General PEI</h1>
            <p class="subtitle">Sistema de Gestión y Seguimiento Educativo</p>
        </div>

        <!-- Acciones superiores -->
        <div class="top-actions">
            <div class="back-button">
                <button type="button" onclick="window.location.href='./../../access.php';">
                    <i class="fas fa-arrow-left"></i> REGRESAR AL MENÚ
                </button>
            </div>
            
            <a class="corner-button-modern" href='./../proyect_transv/management/admin/supervisor/supervisor.php'>
                <i class="fas fa-tasks"></i>
                <span>Seguimiento Proyectos</span>
            </a>
        </div>

        <!-- Formulario de búsqueda mejorado -->
        <div class="search-form">
            <form action="#" method="post">
                <h2><i class="fas fa-file-chart-line"></i> Informe General PEI - Seguimiento de Archivos</h2>
                <div class="search-group">
                    <input type="text" name="filtro" class="modern-input" placeholder="Buscar por nombre o ID del establecimiento educativo" value="<?php echo isset($_POST['filtro']) ? htmlspecialchars($_POST['filtro']) : ''; ?>">
                    <button type="submit" name="filtrar" class="modern-btn">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Controles y opciones -->
        <div class="controls-section">
            <label class="checkbox-modern">
                <input type="checkbox" id="cbox1" value="mostrar_archivos" />
                <span><i class="fas fa-file-alt"></i> Mostrar Archivos Detallados</span>
            </label>

            <a href="./excels.php" class="btn-excel">
                <i class="fas fa-file-excel"></i> Historia de Excel
            </a>
        </div>

        <?php
            if ($resultados && mysqli_num_rows($resultados) > 0) {
                // Indicador y zona para arrastrar (drag-to-scroll)
                echo '<div class="table-drag-handle" style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">';
                echo '<div style="flex:1;color:var(--white);font-weight:600;">';
                echo '<i class="fas fa-arrows-alt-h" style="margin-right:8px;color:var(--white);"></i> Arrastre con el ratón hacia la izquierda/derecha para ver todas las columnas';
                echo '</div>';
                echo '<div style="display:flex;gap:8px">';
                echo '<span style="background:rgba(255,255,255,0.15);padding:6px 10px;border-radius:6px;color:var(--white);font-weight:600">Click y arrastre</span>';
                echo '<button id="toggle-sticky" style="background:rgba(255,255,255,0.18);border:none;padding:6px 10px;border-radius:6px;color:var(--white);font-weight:700;cursor:pointer;margin-left:6px">Sticky headers</button>';
                echo '</div>';
                echo '</div>';
                
                // Observación sobre drag horizontal
                echo '<div style="background:linear-gradient(135deg,rgba(52,152,219,0.9),rgba(46,204,113,0.9));padding:12px 16px;border-radius:8px;margin-bottom:12px;color:white;font-weight:600;box-shadow:0 3px 10px rgba(0,0,0,0.2);">';
                echo '<i class="fas fa-info-circle" style="margin-right:8px;"></i>';
                echo '<strong>💡 Tip:</strong> Mantén presionado el click del ratón sobre la tabla y arrastra hacia la izquierda para ver más columnas. Los encabezados permanecerán fijos para mejor navegación.';
                echo '</div>';
                echo '<div class="table-container">';
                echo "<table>";
                echo "<thead class='table-headers-sticky'>";
                echo "<tr>";
                echo "<th rowspan='2'><i class='fas fa-hashtag'></i><br>ID</th>";
                echo "<th rowspan='2'><i class='fas fa-school'></i><br>Establecimiento Educativo</th>";
                echo "<th class='encabezado encabezado1' colspan='2'><i class='fas fa-building'></i><br><b>INSTITUCIÓN EDUCATIVA</b></th>";
                echo "<th class='encabezado encabezado2' colspan='1'><i class='fas fa-bullseye'></i><br><b>TELEOLÓGICO</b></th>";
                echo "<th class='encabezado encabezado3' colspan='2'><i class='fas fa-graduation-cap'></i><br><b>PEDAGÓGICO</b></th>";
                echo "<th class='encabezado encabezado4' colspan='4'><i class='fas fa-project-diagram'></i><br><b>PLANES-PROGRAMAS-PROYECTOS</b></th>";
                echo "<th class='encabezado encabezado5' colspan='3'><i class='fas fa-child'></i><br><b>PREESCOLAR</b></th>";
                echo "<th class='encabezado encabezado6' colspan='3'><i class='fas fa-handshake'></i><br><b>CONVIVENCIA</b></th>";
                echo "<th rowspan='2'><i class='fas fa-clipboard-list'></i><br>Observaciones</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th><i class='fas fa-file-contract'></i><br>Resolución</th>";
                echo "<th><i class='fas fa-school'></i><br>Establecimiento</th>";
                echo "<th class='oculto'>Archivos IE</th>";
                echo "<th><i class='fas fa-bullseye'></i><br>Teleológico</th>";
                echo "<th class='oculto'>Archivos Teleológico</th>";
                echo "<th><i class='fas fa-th-large'></i><br>Mallas</th>";
                echo "<th class='oculto'>Archivos Mallas</th>";
                echo "<th><i class='fas fa-chart-bar'></i><br>SIEE</th>";
                echo "<th class='oculto'>Archivos SIEE</th>";
                echo "<th><i class='fas fa-arrows-alt'></i><br>Transversales</th>";
                echo "<th class='oculto'>Archivos Transversales</th>";
                echo "<th><i class='fas fa-clipboard'></i><br>Planes-Programas</th>";
                echo "<th class='oculto'>Archivos Planes</th>";
                echo "<th><i class='fas fa-tasks'></i><br>Proyectos/Planes</th>";
                echo "<th class='oculto'>Archivos Proyectos</th>";
                echo "<th><i class='fas fa-clock'></i><br>Intensidad Horaria</th>";
                echo "<th class='oculto'>Archivos Intensidad</th>";
                echo "<th><i class='fas fa-baby'></i><br>Educación Inicial</th>";
                echo "<th class='oculto'>Archivos Ed. Inicial</th>";
                echo "<th><i class='fas fa-book'></i><br>Plan Estudios</th>";
                echo "<th class='oculto'>Archivos Plan Estudios</th>";
                echo "<th><i class='fas fa-chart-line'></i><br>Desarrollo Integral</th>";
                echo "<th class='oculto'>Archivos Desarrollo</th>";
                echo "<th><i class='fas fa-gavel'></i><br>Manual Convivencia</th>";
                echo "<th class='oculto'>Archivos Manual</th>";
                echo "<th><i class='fas fa-users'></i><br>Convivencia Escolar</th>";
                echo "<th class='oculto'>Archivos Convivencia</th>";
                echo "<th><i class='fas fa-bell'></i><br>Circular</th>";
                echo "<th class='oculto'>Archivos Circular</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($fila = mysqli_fetch_assoc($resultados)) {
                    echo "<tr ALIGN=center>";
                    echo "<td>".$fila['id_cole']."</td>";
                    echo "<td>".$fila['nombre_cole']."</td>";
                    $id_cole = $fila['id_cole'];
                    $iconStyle = "style='width: 40px; height: 40px; max-width: 100%;'";
                    $icon = "./../../../../img/visualizar.png";
                    $icon_excel = "./../../../../img/excel.png";
                
                    //IE
                    $tieneResolucion=tieneResolucion($id_cole, $mysqli);
                    echo '<td ' . ($tieneResolucion ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneResolucion ? $tieneResolucion : 'No';
                    
                    echo '</td>';
                    // echo "<td>" . $tieneResolucion. "</td>";

                    $tieneArchivoIe=tieneIe($id_cole, $mysqli);
                    // echo "<td>" . ($tieneArchivoIe ? "Si" : "No") . "</td>";
                    echo '<td ' . ($tieneArchivoIe ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivoIe ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" .mostrarArchivosIe($id_cole, $mysqli). "</td>";

                    
                    //Teológico
                    $tieneArchivos = tieneArchivosTeologico($id_cole);
                    // echo "<td>" . ($tieneArchivos ? "Si" : "No") . "</td>";
                    echo '<td ' . ($tieneArchivos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivos ? 'Si' : 'No';
                    echo '</td>';

                    echo mostrarListaArchivos($id_cole);

                    //mallas
                    $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosMallasColegio ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosMallasColegio ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneArchivosMallasColegio ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarMallasYArchivos($id_cole, $mysqli). "</td>";
                   

                    //siee
                    $tieneArchivosSiee = tieneArchivosSiee($id_cole);
                    echo '<td ' . ($tieneArchivosSiee ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosSiee ? 'Si' : 'No';
                    echo '</td>';
                    echo mostrarListaArchivosSiee($id_cole);

                    //transversal
                    $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                    echo '<td ' . ($tieneProyectoTransversal ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneProyectoTransversal ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosTransversales($id_cole,$mysqli). "</td>";

                    //proyecto pedagógico (Planes - Programas y Proyectos)
                    $tieneArchivosEnLosCuatro = tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosEnLosCuatro ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosEnLosCuatro ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosDeProyectos($id_cole, $mysqli). "</td>";

                    //proyectos y planes
                    $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                    echo '<td ' . ($tienePlanesProyectos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanesProyectos ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosPlanesProyectos($id_cole,$mysqli). "</td>";

                    //intensidad horaria
                    $tieneIntensidadHoraria = tieneIntensidadHoraria($id_cole, $mysqli);
                    echo '<td ' . ($tieneIntensidadHoraria ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneIntensidadHoraria ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosIntensidadHoraria($id_cole, $mysqli) . "</td>";

                 
                    
                    //transicion

                    //educacion inicial
                    $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                    echo '<td ' . ($tieneEducacionInicial ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneEducacionInicial ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneEducacionInicial ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarArchivosEducacionInicial($id_cole,$mysqli). "</td>";
                   

                    //plan aula
                    $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                    echo '<td ' . ($tienePlanAula ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanAula ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tienePlanAula ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarArchivosPlanAula($id_cole,$mysqli). "</td>";
                   

                    //seguimiento desarrollo integral
                    $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                    echo '<td ' . ($tieneIntegral ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneIntegral ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" .mostrarArchivosIntegral($id_cole,$mysqli). "</td>";

                    //manual convivencia
                    $tieneManualConvivencia = tieneManualConvivencia($id_cole, $mysqli);
                    echo '<td ' . ($tieneManualConvivencia ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneManualConvivencia ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosManualConvivencia($id_cole, $mysqli) . "</td>";

                    //convivencia escolar
                    $tieneConvivenciaEscolar = tieneConvivenciaEscolar($id_cole, $mysqli);
                    echo '<td ' . ($tieneConvivenciaEscolar ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneConvivenciaEscolar ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosConvivenciaEscolar($id_cole, $mysqli) . "</td>";

                    //circular
                    $tieneCircular = tieneCircular($id_cole, $mysqli);
                    echo '<td ' . ($tieneCircular ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneCircular ? 'Si' : 'No';
                    echo '</td>';
                    echo "<td class='oculto'>" . mostrarArchivosCircular($id_cole, $mysqli) . "</td>";

                    // $observacion = Observacion($id_cole,$mysql,$contenido);
                    // echo'<td>'.$observacion.'</td>';
                   
                    $contenido = MostrarInformacionObservacion($id_cole, $mysqli);

                    // // Mostramos el contenido de la observación en un formulario
                    // echo '<form method="POST" action="./observacion.php">';
                    // echo '<input type="hidden" name="id_cole" value="' . $id_cole . '">';
                    // echo '<textarea name="nueva_observacion" class="td-textarea">' . htmlspecialchars($contenido) . '</textarea>'; // Usar htmlspecialchars para evitar problemas de seguridad
                    // echo '<input type="submit" value="Guardar">';
                    // echo '</form>';
                    // echo '</td>';
                    echo '<td class="observacion">';
                    echo '<div class="observacion-form">';
                    echo '<input type="hidden" name="id_cole" value="' . $id_cole . '">';
                    echo '<textarea name="nueva_observacion" class="td-textarea" placeholder="Escriba aquí las observaciones para este establecimiento educativo...">' . htmlspecialchars($contenido) . '</textarea>';
                    echo '<button class="buton-observacion" id="guardar-observacion-' . $id_cole . '"><i class="fas fa-save"></i> Guardar</button>';
                    echo '</div>';
                    echo '</td>';
                    



                
                }

                echo "</tbody>";
                echo "</table>";
                
                // Indicador de scroll horizontal
                echo '<div class="scroll-indicator">';
                echo '<i class="fas fa-arrows-alt-h"></i> ';
                echo 'Deslice horizontalmente para ver todas las columnas';
                echo '</div>';
                
                echo '</div>'; // Cierre de table-container

                //reportes generales
                // ...

                $modulo1Cargado = 0;
                $modulo2Cargado = 0;
                $modulo3Cargado = 0;
                $modulo4Cargado = 0;
                $modulo5Cargado = 0;
                $modulo6Cargado = 0;
                $totalCargados = 0;
                $colegiosTotales = 0;

                $colegios = "SELECT * FROM colegios";
                $todos = mysqli_query($mysqli, $colegios);

                if ($todos && mysqli_num_rows($todos) > 0) {
                    while ($fila = mysqli_fetch_assoc($todos)) {
                        // Obtener los valores de $tieneResolucion y $tieneArchivoIe para cada colegio
                        $id_cole = $fila['id_cole'];
                        //IE

                        $tieneResolucion = tieneResolucion($id_cole, $mysqli);
                        $resolucionText = $tieneResolucion ? $tieneResolucion : 'No';

                        $tieneArchivoIe=tieneIe($id_cole, $mysqli);
                        $establecimientoText = $tieneArchivoIe ? 'Si' : 'No';

                        //Teológico
                        $tieneArchivos = tieneArchivosTeologico($id_cole);
                        $teologicoText = $tieneArchivos ? 'Si' : 'No';

                        //Pedagígico|mallas
                        $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                        $mallasText = $tieneArchivosMallasColegio ? 'Si' : 'No';

                        $tieneArchivosSiee = tieneArchivosSiee($id_cole);
                        $sieeText = $tieneArchivosSiee ? 'Si' : 'No';

                        //planes|proyectos
                        $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                        $transversalText = $tieneProyectoTransversal ? 'Si' : 'No';

                        $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                        $planesText = $tienePlanesProyectos ? 'Si' : 'No';

                        //proyectos pedagógicos
                        $tieneArchivosEnLosCuatro =tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);
                        $cuatroText = $tieneArchivosEnLosCuatro ? 'Si' : 'No';

                        //transición
                        $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                        $educacionText = $tieneEducacionInicial ? 'Si' : 'No';

                        $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                        $planAulaText = $tienePlanAula ? 'Si' : 'No';

                        $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                        $integralText = $tieneIntegral ? 'Si' : 'No';

                        //convivencia
                        $tieneManualConvivencia = tieneManualConvivencia($id_cole, $mysqli);
                        $manualConvivenciaText = $tieneManualConvivencia ? 'Si' : 'No';

                        $tieneConvivenciaEscolar = tieneConvivenciaEscolar($id_cole, $mysqli);
                        $convivenciaEscolarText = $tieneConvivenciaEscolar ? 'Si' : 'No';

                        $tieneCircular = tieneCircular($id_cole, $mysqli);
                        $circularText = $tieneCircular ? 'Si' : 'No';

                        // Módulo 1 I.E
                        if ($resolucionText != 'No' && $establecimientoText != 'No') {
                            $modulo1Cargado++;
                        }
                        if ($teologicoText != 'No') {
                            $modulo2Cargado++;
                        }
                        if ($mallasText != 'No' && $sieeText != 'No') {
                            $modulo3Cargado++;
                        }
                        if ($transversalText != 'No' && $planesText != 'No' && $cuatroText  != 'No') {
                            $modulo4Cargado++;
                        }

                        if ($educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No') {
                            $modulo5Cargado++;
                        }

                        if ($manualConvivenciaText != 'No' && $convivenciaEscolarText != 'No' && $circularText != 'No') {
                            $modulo6Cargado++;
                        }

                        if ($cuatroText  != 'No' && $educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No'&& $transversalText != 'No' && $planesText != 'No' && $mallasText != 'No' && $sieeText != 'No' && $teologicoText != 'No' && $resolucionText != 'No' && $establecimientoText != 'No' && $manualConvivenciaText != 'No' && $convivenciaEscolarText != 'No' && $circularText != 'No') {
                            $totalCargados++;
                        }

                        $colegiosTotales++;
                    }

                    echo "<div class='resultado-final'>";
                    echo "<table border='1'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th></th>";
                    echo "<th>I.E</th>";
                    echo "<th>Teleológico</th>";
                    echo "<th>Pedagógico</th>";
                    echo "<th>Planes-Programas-Proyectos</th>";
                    echo "<th>Preescolar</th>";
                    echo "<th>Convivencia</th>";
                    echo "<th>Todos los módulos</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<th>Han cargado</th>";
                    echo "<td>{$modulo1Cargado}</td>";
                    echo "<td>{$modulo2Cargado}</td>";
                    echo "<td>{$modulo3Cargado}</td>";
                    echo "<td>{$modulo4Cargado}</td>";
                    echo "<td>{$modulo5Cargado}</td>";
                    echo "<td>{$modulo6Cargado}</td>";
                    echo "<td>{$totalCargados}</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>No han cargado</th>";
                    echo "<td>" . ($colegiosTotales - $modulo1Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo2Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo3Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo4Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo5Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo6Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $totalCargados) . "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                }

            } else {
                echo "No se encontraron resultados.";
            }
            ?>
            
        </div>
        <div class="separador"></div>
        

    </div>
    <script src="./js/generalReport.js"></script>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['id_cole']) && isset($_POST['nueva_observacion'])) {
        $id_cole = $_POST['id_cole'];
        $nueva_observacion = $_POST['nueva_observacion'];

        if (ActualizarObservacion($id_cole, $nueva_observacion, $mysqli)) {
            echo 'Observación actualizada exitosamente.';
        } else {
            // echo 'Error al actualizar la observación.';
        }
    } else {
        // echo 'Datos del formulario incompletos.';
    }
} else {
    // echo 'Acceso no permitido.';
}
?>

        <!-- Footer informativo -->
        <div class="footer-info">
            <p style="margin: 0; color: var(--dark-color); font-size: 1.1rem;">
                <i class="fas fa-info-circle" style="color: var(--primary-color); margin-right: 0.5rem;"></i> 
                <strong style="color: var(--primary-color);">Leyenda de Estados:</strong>
            </p>
            <div style="margin-top: 1rem;">
                <span class="legend-item" style="color: var(--success-color);">
                    <i class="fas fa-check-circle"></i> Verde = Completo
                </span>
                <span class="legend-item" style="color: var(--danger-color);">
                    <i class="fas fa-times-circle"></i> Rojo = Faltante
                </span>
                <span class="legend-item" style="color: var(--primary-color);">
                    <i class="fas fa-eye"></i> Use el checkbox para ver más detalles
                </span>
            </div>
        </div>
    </div>

<script>
    // Funcionalidad para mostrar/ocultar archivos
    document.getElementById('cbox1').addEventListener('change', function() {
        const elements = document.querySelectorAll('.oculto');
        const isChecked = this.checked;
        
        elements.forEach(function(element) {
            element.style.display = isChecked ? 'table-cell' : 'none';
        });
    });

    // Mejorar experiencia de scroll en tabla
    document.addEventListener('DOMContentLoaded', function() {
        const tableContainer = document.querySelector('.table-container');
        const scrollIndicator = document.querySelector('.scroll-indicator');
        
        if (tableContainer && scrollIndicator) {
            // Verificar si necesita scroll
            if (tableContainer.scrollWidth > tableContainer.clientWidth) {
                scrollIndicator.style.display = 'block';
                
                // Ocultar indicador después de hacer scroll
                tableContainer.addEventListener('scroll', function() {
                    if (this.scrollLeft > 50) {
                        scrollIndicator.style.opacity = '0.5';
                    } else {
                        scrollIndicator.style.opacity = '1';
                    }
                });
            } else {
                scrollIndicator.style.display = 'none';
            }
        }
    });

    // Drag-to-scroll (click and drag) for .table-container with vertical drag support
    (function() {
        let isDown = false;
        let startX, startY;
        let scrollLeft, scrollTop;
        const slider = document.querySelector('.table-container');

        if (!slider) return;

        function getScrollableParent(el) {
            let parent = el;
            while (parent) {
                const overflowY = window.getComputedStyle(parent).overflowY;
                if ((overflowY === 'auto' || overflowY === 'scroll') && parent.scrollHeight > parent.clientHeight) {
                    return parent;
                }
                parent = parent.parentElement;
            }
            return window;
        }

        const scrollParent = getScrollableParent(slider);

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            startY = e.pageY - slider.offsetTop;
            scrollLeft = slider.scrollLeft;
            scrollTop = (scrollParent === window) ? window.scrollY : scrollParent.scrollTop;
            e.preventDefault();
        });

        function endDrag() {
            isDown = false;
            slider.classList.remove('active');
        }

        slider.addEventListener('mouseleave', endDrag);
        slider.addEventListener('mouseup', endDrag);

        slider.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const y = e.pageY - slider.offsetTop;
            const dx = x - startX;
            const dy = y - startY;

            // If vertical movement is greater, scroll vertically the nearest scrollable parent
            if (Math.abs(dy) > Math.abs(dx)) {
                if (scrollParent === window) {
                    window.scrollTo({ top: scrollTop - dy });
                } else {
                    scrollParent.scrollTop = scrollTop - dy;
                }
            } else {
                const walk = dx * 1; // horizontal scroll speed
                slider.scrollLeft = scrollLeft - walk;
            }
        });
    })();

    // Toggle sticky headers button
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-sticky');
        const tableContainer = document.querySelector('.table-container');
        if (toggleBtn && tableContainer) {
            toggleBtn.addEventListener('click', function() {
                tableContainer.classList.toggle('sticky-headers');
                if (tableContainer.classList.contains('sticky-headers')) {
                    toggleBtn.textContent = 'Sticky ON';
                    toggleBtn.style.background = 'rgba(255,255,255,0.9)';
                    toggleBtn.style.color = 'var(--primary-color)';
                } else {
                    toggleBtn.textContent = 'Sticky headers';
                    toggleBtn.style.background = 'rgba(255,255,255,0.18)';
                    toggleBtn.style.color = 'var(--white)';
                }
            });
        }
    });

    // Funcionalidad mejorada para observaciones con AJAX
    $(document).ready(function () {
        $("button[id^='guardar-observacion']").click(function (e) {
            e.preventDefault();

            const button = $(this);
            const id_cole = button.siblings("input[name='id_cole']").val();
            const nueva_observacion = button.siblings("textarea[name='nueva_observacion']").val();

            // Mostrar estado de carga
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

            $.ajax({
                type: "POST",
                url: "./observacion.php",
                data: { id_cole: id_cole, nueva_observacion: nueva_observacion },
                success: function(response) {
                    button.prop('disabled', false).html('<i class="fas fa-check"></i> Guardado');
                    
                    // Mostrar notificación de éxito
                    const notification = $('<div class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 1000; padding: 15px; border-radius: 8px; background: var(--success-color); color: white; box-shadow: var(--shadow);"><i class="fas fa-check-circle"></i> Observación guardada exitosamente</div>');
                    $('body').append(notification);
                    
                    setTimeout(function() {
                        notification.fadeOut();
                        button.html('<i class="fas fa-save"></i> Guardar');
                    }, 3000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error de conexión:", errorThrown);
                    button.prop('disabled', false).html('<i class="fas fa-exclamation-triangle"></i> Error');
                    
                    // Mostrar notificación de error
                    const errorNotification = $('<div class="alert alert-error" style="position: fixed; top: 20px; right: 20px; z-index: 1000; padding: 15px; border-radius: 8px; background: var(--danger-color); color: white; box-shadow: var(--shadow);"><i class="fas fa-exclamation-triangle"></i> Error al guardar la observación</div>');
                    $('body').append(errorNotification);
                    
                    setTimeout(function() {
                        errorNotification.fadeOut();
                        button.html('<i class="fas fa-save"></i> Guardar');
                    }, 3000);
                }
            });
        });
    });
</script>
</body>
</html>