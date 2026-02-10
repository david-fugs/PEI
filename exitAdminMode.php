<?php
/**
 * Script para salir del modo de visualización de administrador
 */
session_start();

if (isset($_POST['exit_admin_mode'])) {
    // Limpiar las variables de sesión del modo administrador
    unset($_SESSION['admin_viewing_id_cole']);
    unset($_SESSION['admin_view_mode']);
    
    // Redirigir al área administrativa
    header('Location: code/ie/showIeAdmin.php');
    exit();
}

// Si se accede directamente sin POST, redirigir al inicio
header('Location: access.php');
exit();
?>
