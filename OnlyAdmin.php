<?php
 $tipo_usuario   = $_SESSION['tipo_usuario'];
if ($tipo_usuario !== "1") {
   header(" Location: index.php");
    exit();

}

if ($tipo_usuario === "1" && $_SESSION['admin']['id'] !== $id) {
    header("Location: index.php");
    exit();
  
}

?>