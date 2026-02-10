<?php
/**
 * Helper para manejar el modo de visualización del administrador
 * Este archivo permite que los administradores vean el contenido de cualquier institución
 * sin modificar la sesión principal
 */

// Variable global para almacenar el id_cole efectivo
$efectivo_id_cole = null;
$admin_view_mode = false;

// Verificar si se está accediendo en modo administrador
if (isset($_POST['admin_id_cole']) && isset($_POST['admin_view_mode'])) {
    // Modo visualización administrador
    $efectivo_id_cole = (int)$_POST['admin_id_cole'];
    $admin_view_mode = true;
    
    // Almacenar en sesión temporal para mantener durante la navegación
    $_SESSION['admin_viewing_id_cole'] = $efectivo_id_cole;
    $_SESSION['admin_view_mode'] = true;
    
} elseif (isset($_SESSION['admin_view_mode']) && $_SESSION['admin_view_mode'] === true) {
    // Mantener el modo administrador si ya está activo en la sesión
    $efectivo_id_cole = $_SESSION['admin_viewing_id_cole'];
    $admin_view_mode = true;
    
} elseif (isset($_SESSION['id_cole'])) {
    // Modo normal - usar el id_cole de la sesión del usuario
    $efectivo_id_cole = $_SESSION['id_cole'];
    $admin_view_mode = false;
}

// Función para obtener el id_cole efectivo
function getEfectivoIdCole() {
    global $efectivo_id_cole;
    return $efectivo_id_cole;
}

// Función para verificar si está en modo administrador
function isAdminViewMode() {
    global $admin_view_mode;
    return $admin_view_mode;
}

// Función para salir del modo administrador
function exitAdminViewMode() {
    unset($_SESSION['admin_viewing_id_cole']);
    unset($_SESSION['admin_view_mode']);
}

// Función para mostrar banner de modo administrador
function showAdminViewBanner() {
    global $admin_view_mode, $efectivo_id_cole, $mysqli;
    
    if ($admin_view_mode && $efectivo_id_cole) {
        // Verificar que $mysqli esté disponible
        if (!isset($mysqli)) {
            include_once(__DIR__ . '/conexion.php');
        }
        
        // Obtener nombre del colegio
        $query = "SELECT nombre_cole FROM colegios WHERE id_cole = $efectivo_id_cole";
        $result = mysqli_query($mysqli, $query);
        $colegio = mysqli_fetch_assoc($result);
        $nombre_cole = $colegio['nombre_cole'] ?? 'Desconocido';
        
        echo '
        <div style="background: linear-gradient(135deg, #f39c12, #e67e22); color: white; padding: 15px; text-align: center; position: sticky; top: 0; z-index: 9999; box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-bottom: 20px; border-radius: 8px;">
            <div style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="flex: 1; text-align: left;">
                    <i class="fas fa-eye me-2"></i>
                    <strong>MODO VISUALIZACIÓN ADMINISTRADOR</strong>
                    <span style="margin-left: 15px;">
                        <i class="fas fa-school me-2"></i>Viendo: <strong>' . htmlspecialchars($nombre_cole) . '</strong>
                    </span>
                </div>
                <div>
                    <a href="javascript:void(0);" onclick="exitAdminMode()" style="background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>Salir del Modo Admin
                    </a>
                </div>
            </div>
        </div>
        <style>
        a[onclick*="exitAdminMode"]:hover {
            background: rgba(255,255,255,0.3) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        </style>
        <script>
        function exitAdminMode() {
            if (confirm("¿Desea salir del modo de visualización de administrador y volver al panel administrativo?")) {
                window.close(); // Intentar cerrar la pestaña
                // Si no se puede cerrar (no fue abierta por script), redirigir
                setTimeout(function() {
                    window.location.href = "' . ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/PEI/code/ie/showIeAdmin.php";
                }, 100);
            }
        }
        </script>
        ';
    }
}
?>
