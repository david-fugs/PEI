<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../../index.php");
    exit;
}

include("../../conexion.php");

if(isset($_GET['archivo']) && isset($_GET['nit_cole'])) {
    $archivo = basename($_GET['archivo']); // Sanitizar el nombre del archivo
    $nit_cole = mysqli_real_escape_string($mysqli, $_GET['nit_cole']);
    
    // Construir la ruta completa del archivo
    $ruta_archivo = 'files/' . $nit_cole . '/' . $archivo;
    
    // Verificar que el archivo existe
    if(file_exists($ruta_archivo)) {
        // Intentar eliminar el archivo
        if(unlink($ruta_archivo)) {
            // Verificar si el directorio quedó vacío
            $directorio = 'files/' . $nit_cole;
            $archivos_restantes = array_diff(scandir($directorio), array('.', '..'));
            
            // Si está vacío, eliminar el directorio
            if(count($archivos_restantes) == 0) {
                rmdir($directorio);
            }
            
            echo "<script>
                    alert('Archivo eliminado exitosamente');
                    window.location.href='addieedit.php?cod_dane_cole=" . urlencode($_GET['cod_dane_cole']) . "';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al eliminar el archivo');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('El archivo no existe');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Parámetros inválidos');
            window.history.back();
          </script>";
}
?>
