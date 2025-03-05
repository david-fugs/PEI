<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar proyectos de colegio</title>
   

    <link rel="stylesheet" href="./../../../../css/editProject.css">
    
</head>
<body>
    <?php
    include("../../../../conexion.php");
    include("../../../../sessionCheck.php");
   
   
    $id_cole = $_GET['id_cole'];
    $id_proyecto = $_GET['id_proyecto'];
    ?>

    <?php
    // Obtener el nombre del colegio
    $sql = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $nombre_cole = $row['nombre_cole'];
    } else {
        echo "Error en la consulta: " . mysqli_error($mysqli);
    }
    ?>
<?php
include("../../../../questions.php");
include("../../../../answers.php");

$sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole and Id_proyec_pedag_transv=$id_proyecto";
$result = mysqli_query($mysqli, $sql);
$numProjects = 0;

if ($result && mysqli_num_rows($result) > 0) {
   


    echo '<div class="college">';
    echo '<h2>' . $nombre_cole . '</h2>';
    echo '</div>';
   
    echo '<div class="container">';
    echo '<form method="post" action="">';
    while ($row = mysqli_fetch_assoc($result)) {
        
        $nameProject = $selec_proyec_transv = $row['selec_proyec_transv'];
        $numProjects++;

        // id de proyecto individual.
        $id_project= $id_proyecto = $row['Id_proyec_pedag_transv'];
        // echo '<h2>' . $id_project . '</h2>';
        
        foreach ($answers as $index => $columnName) {
            echo '<div class="project">';
            echo '<div class="question">' . $questions[$index] . '</div>';
            
            $fieldType = $fieldTypesNewAnswers[$columnName];

            
            if ($fieldType === 'textarea') {
                // Mostrar respuesta antigua en un textarea
                echo '<textarea name="' . $columnName . '">' . $row[$columnName] . '</textarea>';
            } elseif ($fieldType === 'int') {
                // Mostrar respuesta antigua en un campo numérico
                echo '<input type="number" min="0" name="' . $columnName . '" value="' . $row[$columnName] . '">';
            }
            elseif ($fieldType === 'char') {
                // echo '<textarea name="' . $columnName . '">' . $row[$columnName] . '</textarea>';
                    if($columnName == 'selec_proyec_transv'){
                        echo '<textarea name="' . $columnName . '" readonly>' . $row[$columnName] . '</textarea>';

                        // echo '<select class="form-control" name="' . $columnName . '" required id="selectProy">';
    
                        // $options = array(
                        //     "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC",
                        //     "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE",
                        //     "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS",
                        //     "PROYECTO DE EDUCACION VIAL"  
                        // );
                        // foreach ($options as $option) {
                        //     $selected = $row[$columnName] === $option ? "selected" : "";
                        //     echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        // }
                        // echo '</select>';
                    }
                    elseif ($columnName === 'si_pei') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                
                    elseif ($columnName === 'si_mes_trab') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                    
                    elseif ($columnName === 'si_prob') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                
                    elseif ($columnName === 'fuert_prob') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "FUERTEMENTE",
                            "DEBILMENTE", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                
                    elseif ($columnName === 'si_sol_prob') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                
                    elseif ($columnName === 'fuert_art_areas') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "FUERTEMENTE",
                            "DEBILMENTE",
                            "NO EXISTE ARTICULACION" 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                    elseif ($columnName === 'exist_niv_proy_1') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "EXISTENCIA",
                            "PERTINENCIA",
                            "APROPIACION" ,
                            "MEJORAMIENTO CONTINUO"
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                
                    elseif ($columnName === 'si_pmi') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                    
                    elseif ($columnName === 'si_proy_vin') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                    elseif ($columnName === 'si_vin_conv_esc') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                            "SI",
                            "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                        echo '</select>';}
                
                    elseif ($columnName === 'niv_cicl_desp') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                                "Transición",
                                "Básica primaria", 
                                "Básica secundaria",
                                "Media"
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                        }
                            echo '</select>';}
                    elseif ($columnName === 'si_cert_form_cap') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                                "SI",
                                "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                            }
                            echo '</select>';}
                    elseif ($columnName === 'si_fue_cert') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                                "SI",
                                "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                            }
                            echo '</select>';}

                    //educa
                    elseif ($columnName === 'si_fuer_edu_art_int') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                                "FUERTE",
                                "DEBIL", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                            }
                            echo '</select>';}
                    //EDUCATIVAS
                    elseif ($columnName === 'si_fuer_edu_gub_int') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                                "FUERTE",
                                "DEBIL", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                            }
                            echo '</select>';}
                    elseif ($columnName === 'si_fuer_edu_art_no_int') {
                            echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                            $options = array(
                                "FUERTE",
                                "DEBIL", 
                            );
                            foreach ($options as $option) {
                                $selected = $row[$columnName] === $option ? "selected" : "";
                                echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                                }
                                echo '</select>';}
                    elseif ($columnName === 'si_fuer_no_gub') {
                            echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                            $options = array(
                                    "FUERTE",
                                    "DEBIL", 
                            );
                            foreach ($options as $option) {
                                $selected = $row[$columnName] === $option ? "selected" : "";
                                echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                                }
                                echo '</select>';}
                    //EDUCATIVAS
                    elseif ($columnName === 'Fue_oport') {
                        echo '<select class="form-control" name="' . $columnName . '" required id="si_pei">';
                        $options = array(
                                "SI",
                                "NO", 
                        );
                        foreach ($options as $option) {
                            $selected = $row[$columnName] === $option ? "selected" : "";
                            echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                            }
                            echo '</select>';}
                        
                   
                }
            
            
           
            
            echo '</div>';

            

       
        }
        echo '<input type="hidden" name="id_project" value="' . $id_project . '">';
        echo '<input type="hidden" name="id_cole" value="' . $id_cole . '">';
        echo '<input type="hidden" name="nombre_cole" value="' . $nombre_cole . '">';
        echo'<div class="update">';
        echo '<button  name="btn-update" >';
        echo '<img src="./../../../../img/save.png" width="27" height="27"> ACTUALIZAR';
        echo '</button>';
      
        echo'</div>';
        echo '</form>';
                

    }
    echo'<div class="back">';
    echo '<button type="button"  role="link" onclick="window.location.href=\'./colleges.php\';">';
    echo '<img src="./../../../../img/atras.png" width="27" height="27"> ATRÁS';
    echo '</button>';
    echo'</div>';
    //  echo'<a href="./collegues.php">Ir a la página de colegios</a>';
    
}
else {
    echo '<div class="container">';
    echo '<h2>' . $nombre_cole . '</h2>';
    echo "No se encontraron proyectos para este colegio.";
    echo '</div>';

    
  
   
}


?>

<div>
<?php
if (isset($_POST['btn-update'])) {
    $id_project = $_POST['id_project']; // Obtener el valor de id_project desde el formulario
    $id_cole = $_POST['id_cole']; 
    $nombre_cole = $_POST['nombre_cole']; 

    $updateColumns = array();
    $error = false; // Agregar variable para rastrear si hay errores
    
    foreach ($answers as $columnName) {
        $rawValue = isset($_POST[$columnName]) ? $_POST[$columnName] : ''; // Obtener el valor crudo de $_POST
        
        // Sanear el valor y asegurarse de que no sea NULL
        $sanitizedValue = ($rawValue !== null) ? mysqli_real_escape_string($mysqli, $rawValue) : '0';
    
        $updateColumns[] = "$columnName = '$sanitizedValue'"; // Agregar a la lista de columnas a actualizar
    
        if (empty($rawValue) && $sanitizedValue !== '0') {
            $error = true; // Marcar como error si hay campos vacíos (excepto '0')
        }
    }
    

    
        $updateQuery = "UPDATE proyec_pedag_transv SET " . implode(", ", $updateColumns) . " WHERE Id_proyec_pedag_transv = $id_project";
            $updateResult = mysqli_query($mysqli, $updateQuery);
            
            
                //se recarga la página
                if ($updateResult) {
                    echo '<div class="container-messaje">';
                    echo '<div class="success-message">Datos actualizados correctamente</div>';
                    echo '</div>';
                    //se recarga la página
                    echo "<script>
                    if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                    }
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000); // Recarga la página después de 5000 milisegundos (5 segundos)
                    </script>";
                    echo '<script>
                    // Función para mostrar una alerta de éxito automáticamente con estilo
                    window.onload = function() {
                        var customAlert = document.createElement("div");
                        customAlert.innerHTML = "Datos actualizados correctamente";
                        customAlert.style.backgroundColor = "green"; // Cambia el color de fondo a verde
                        customAlert.style.color = "white";
                        customAlert.style.padding = "10px";
                        customAlert.style.borderRadius = "5px";
                        customAlert.style.boxShadow = "0px 4px 6px rgba(0, 0, 0, 0.2)";
                        customAlert.style.position = "fixed";
                        customAlert.style.top = "20px";
                        customAlert.style.left = "50%";
                        customAlert.style.transform = "translateX(-50%)";
                        customAlert.style.textAlign = "center";
                        customAlert.style.zIndex = "9999";
                        document.body.appendChild(customAlert);
                        
                        // Cierra la alerta después de 3 segundos
                        setTimeout(function() {
                            document.body.removeChild(customAlert);
                        }, 3000);
                    }
                </script>';
               
                
                
            } else {
                echo '<div class="container-messaje">';
                echo '<div class="error-message">Error al actualizar los datos: ' . mysqli_error($mysqli) . '</div>';
                echo '</div>';
            }
    }




?> 
</div>
</body>
</html>
