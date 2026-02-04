<?php
/**
 * Función auxiliar para generar HTML de archivos colapsables
 * 
 * @param string $content El contenido HTML completo de los archivos
 * @param int $totalArchivos Número total de archivos
 * @param string $id_cole ID del colegio (para generar IDs únicos)
 * @param string $tipo Tipo de archivo (para generar IDs únicos)
 * @return string HTML con archivos colapsables o contenido normal
 */
function generarArchivosColapsables($content, $totalArchivos, $id_cole, $tipo) {
    $uniqueId = $tipo . "_" . $id_cole . "_" . uniqid();
    
    // Verificar si el contenido tiene archivos reales o solo mensajes de "sin archivos"
    $tieneArchivosReales = (stripos($content, '<a href') !== false);
    $tieneSoloSinArchivos = (stripos($content, 'Sin archivos cargados') !== false || 
                              stripos($content, 'No hay archivos') !== false) && !$tieneArchivosReales;
    
    // Si solo tiene mensajes de sin archivos, retornar mensaje simple
    if ($tieneSoloSinArchivos) {
        return "Sin archivos cargados";
    }
    
    // Contar si hay muchos archivos reales
    $lineas = substr_count($content, '<br>') + substr_count($content, '</a>');
    $tieneContenidoRepetitivo = ($lineas > 3 || $totalArchivos > 3 || strlen($content) > 500);
    
    if ($tieneContenidoRepetitivo && $tieneArchivosReales) {
        // Extraer preview (primeros 200 caracteres del contenido)
        $preview = mb_substr($content, 0, 200);
        
        return "
            <div class='archivos-container' id='container_$uniqueId'>
                <div class='archivos-lista'>
                    " . $preview . "...
                </div>
            </div>
            <button class='toggle-archivos' onclick='toggleArchivos(\"$uniqueId\", event)'>
                <i class='fas fa-eye'></i>
                <span id='btn_text_$uniqueId'>Ver todos</span>
                <span class='archivos-badge'>" . max($totalArchivos, $lineas) . "</span>
            </button>
            <div id='full_content_$uniqueId' style='display:none;'>$content</div>
        ";
    } else {
        return $content;
    }
}

/**
 * Función para contar archivos en un directorio
 * 
 * @param string $path Ruta del directorio
 * @return int Número de archivos
 */
function contarArchivosEnDirectorio($path) {
    $count = 0;
    if (file_exists($path) && is_dir($path)) {
        $directorio = opendir($path);
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo) && $archivo != '.' && $archivo != '..') {
                $count++;
            }
        }
        closedir($directorio);
    }
    return $count;
}
?>
