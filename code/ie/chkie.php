<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $nit_cole = (string)$_POST['nit_cole'];
    
    $result = $mysqli->query(
        'SELECT * FROM colegios WHERE nit_cole = "'.strtolower($nit_cole).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NIT DEL COLEGIO!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> La I.E. no está registrada.</div>';
    }
}