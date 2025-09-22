<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

header("Content-Type: text/html;charset=utf-8");
$nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario'];
$id_cole = $_SESSION['id_cole'];

include("../../conexion.php");

// Obtener información del colegio
$sql_colegio = "SELECT cod_dane_cole, nit_cole, nombre_cole FROM colegios WHERE id_cole = $id_cole";
$result_colegio = mysqli_query($mysqli, $sql_colegio);
$colegio = mysqli_fetch_assoc($result_colegio);

// No se usan sedes en este modal; eliminada la selección de sede

// Obtener áreas y asignaturas de configuración
$sql_areas = "SELECT DISTINCT area FROM areas_asignaturas_config WHERE activa = 1 ORDER BY orden_area";
$result_areas = mysqli_query($mysqli, $sql_areas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | Intensidad Horaria Semanal</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-principal {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .header-title {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .btn-modern {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary.btn-modern {
            background: linear-gradient(45deg, #667eea, #764ba2);
        }

        .btn-success.btn-modern {
            background: linear-gradient(45deg, #56ab2f, #a8e6cf);
        }

        .btn-warning.btn-modern {
            background: linear-gradient(45deg, #f093fb, #f5576c);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .grado-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .grado-item {
            text-align: center;
        }

        .grado-label {
            display: block;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .hora-input {
            width: 80px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 8px;
        }

        .hora-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .total-horas {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            margin-top: 20px;
        }

        .alert {
            border-radius: 15px;
            border: none;
        }

        .info-card {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
        }
    </style>
    <style>
        /* Make the intensidad modal wider than default modal-xl and responsive */
        #intensidadModal .modal-dialog {
            max-width: 1400px; /* wider than default modal-xl */
            width: 95%;
        }

        @media (max-width: 1400px) {
            #intensidadModal .modal-dialog {
                max-width: 100%;
                width: calc(100% - 30px);
                margin: 10px auto;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="container-principal">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="header-title">
                        <i class="fas fa-clock me-3"></i>
                        INTENSIDAD HORARIA SEMANAL POR ÁREAS Y ASIGNATURAS POR GRADOS
                    </h1>
                </div>
            </div>

            <!-- Información del colegio -->
            <div class="info-card">
                <div class="row">
                    <div class="col-md-4">
                        <strong><i class="fas fa-school me-2"></i>Institución:</strong><br>
                        <?php echo htmlspecialchars($colegio['nombre_cole']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-id-card me-2"></i>DANE:</strong><br>
                        <?php echo htmlspecialchars($colegio['cod_dane_cole']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-certificate me-2"></i>NIT:</strong><br>
                        <?php echo htmlspecialchars($colegio['nit_cole']); ?>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="row mb-4">
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-success btn-modern mr-3" data-toggle="modal" data-target="#intensidadModal">
                        <i class="fas fa-plus me-2"></i>Agregar Intensidad Horaria
                    </button>
                    <button type="button" class="btn btn-primary btn-modern" onclick="exportarExcel()">
                        <i class="fas fa-file-excel me-2"></i>Exportar a Excel
                    </button>
                </div>
            </div>

            <!-- Tabla de intensidad horaria -->
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tablaIntensidad">
                    <thead>
                        <tr>
                            <th rowspan="2"><i class="fas fa-layer-group me-2"></i>ÁREA</th>
                            <th rowspan="2"><i class="fas fa-book me-2"></i>ASIGNATURA</th>
                            <th colspan="11"><i class="fas fa-graduation-cap me-2"></i>GRADOS</th>
                            <th rowspan="2"><i class="fas fa-calculator me-2"></i>TOTAL</th>
                            <th rowspan="2"><i class="fas fa-cogs me-2"></i>ACCIONES</th>
                        </tr>
                        <tr>
                            <?php for ($i = 1; $i <= 11; $i++): ?>
                                <th><?php echo $i; ?>°</th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <!-- Los datos se cargarán aquí via AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Botón volver -->
            <div class="text-center mt-4">
                <a href="../ie/showIe.php" class="btn btn-secondary btn-modern">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Menú Principal
                </a>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar intensidad horaria -->
    <div class="modal fade" id="intensidadModal" tabindex="-1" aria-labelledby="intensidadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="intensidadModalLabel">
                        <i class="fas fa-clock me-2"></i>Configurar Intensidad Horaria
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form id="formIntensidad" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" id="accion" value="agregar">
                        <input type="hidden" name="id_registro" id="id_registro">
                        


                        <!-- Selección de área y asignatura -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="area" class="form-label">
                                    <i class="fas fa-layer-group me-1"></i>Área
                                </label>
                                <select name="area" id="area" class="form-select" required>
                                    <option value="">── Seleccione un área ──</option>
                                    <?php
                                    mysqli_data_seek($result_areas, 0);
                                    while ($area = mysqli_fetch_assoc($result_areas)): 
                                    ?>
                                        <option value="<?php echo htmlspecialchars($area['area']); ?>">
                                            <?php echo htmlspecialchars($area['area']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="asignatura" class="form-label">
                                    <i class="fas fa-book me-1"></i>Asignatura
                                </label>
                                <select name="asignatura" id="asignatura" class="form-select" required>
                                    <option value="">── Primero seleccione un área ──</option>
                                </select>
                            </div>
                        </div>

                        <!-- Horas por grado -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-graduation-cap me-1"></i>Horas semanales por grado
                            </label>
                            <div class="grado-container">
                                <?php for ($i = 1; $i <= 11; $i++): ?>
                                    <div class="grado-item">
                                        <label class="grado-label">Grado <?php echo $i; ?>°</label>
                                        <input type="number" 
                                               class="form-control hora-input" 
                                               name="grado_<?php echo $i; ?>" 
                                               id="grado_<?php echo $i; ?>"
                                               min="0" 
                                               max="40" 
                                               step="0.5" 
                                               value="0"
                                               placeholder="0">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Total de horas -->
                        <div class="total-horas">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5><i class="fas fa-calculator me-2"></i>Total de horas semanales:</h5>
                                </div>
                                <div class="col-md-4">
                                    <h3 id="totalHoras">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="fas fa-save me-2"></i>Guardar
                        </button>
                        <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts al final del body -->
    <script src="../../js/jquery-3.1.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            cargarDatos();
            calcularTotalHoras();

            // Al pulsar Agregar, resetear el formulario y preparar modal
            $(document).on('click', '.btn-success[data-toggle="modal"][data-target="#intensidadModal"]', function() {
                $('#formIntensidad')[0].reset();
                $('#accion').val('agregar');
                $('#id_registro').val('');
                $('#intensidadModalLabel').text('Configurar Intensidad Horaria');
                $('#asignatura').html('<option value="">── Primero seleccione un área ──</option>');
                calcularTotalHoras();
            });

            // Cambio de área - cargar asignaturas
            $('#area').change(function() {
                const area = $(this).val();
                $('#asignatura').html('<option value="">── Cargando asignaturas... ──</option>');
                
                if (area) {
                    $.ajax({
                        url: 'obtener_asignaturas.php',
                        type: 'POST',
                        data: { area: area },
                        dataType: 'json',
                        success: function(response) {
                            let options = '<option value="">── Seleccione una asignatura ──</option>';
                            if (response.success && response.asignaturas.length > 0) {
                                response.asignaturas.forEach(function(asignatura) {
                                    options += `<option value="${asignatura}">${asignatura}</option>`;
                                });
                            }
                            $('#asignatura').html(options);
                        },
                        error: function() {
                            $('#asignatura').html('<option value="">── Error al cargar asignaturas ──</option>');
                        }
                    });
                } else {
                    $('#asignatura').html('<option value="">── Primero seleccione un área ──</option>');
                }
            });

            // Calcular total de horas cuando cambian los inputs
            $('input[type="number"]').on('input', calcularTotalHoras);

            // Envío del formulario
            $('#formIntensidad').submit(function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                
                $.ajax({
                    url: 'guardar_intensidad.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#intensidadModal').modal('hide');
                            $('#formIntensidad')[0].reset();
                            cargarDatos();
                            mostrarAlerta('success', response.message);
                        } else {
                            if (response.duplicate) {
                                // Mostrar SweetAlert2 indicando duplicado
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Asignatura existente',
                                    text: response.message,
                                    confirmButtonText: 'Aceptar'
                                });
                            } else {
                                mostrarAlerta('danger', response.message);
                            }
                        }
                    },
                    error: function() {
                        mostrarAlerta('danger', 'Error al guardar los datos.');
                    }
                });
            });
        });

        function calcularTotalHoras() {
            let total = 0;
            for (let i = 1; i <= 11; i++) {
                const valor = parseFloat($('#grado_' + i).val()) || 0;
                total += valor;
            }
            $('#totalHoras').text(total.toFixed(1));
        }

        function cargarDatos() {
            $.ajax({
                url: 'obtener_intensidad.php',
                type: 'GET',
                data: { id_cole: <?php echo $id_cole; ?> },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        mostrarDatos(response.datos);
                    } else {
                        $('#cuerpoTabla').html('<tr><td colspan="15" class="text-center">No hay datos registrados</td></tr>');
                    }
                },
                error: function() {
                    $('#cuerpoTabla').html('<tr><td colspan="15" class="text-center text-danger">Error al cargar los datos</td></tr>');
                }
            });
        }

        function mostrarDatos(datos) {
            let html = '';
            
            if (datos.length === 0) {
                html = '<tr><td colspan="15" class="text-center">No hay datos registrados</td></tr>';
            } else {
                datos.forEach(function(registro) {
                    html += `
                        <tr>
                            <td>${registro.area}</td>
                            <td>${registro.asignatura}</td>
                            <td>${registro.grado_1}</td>
                            <td>${registro.grado_2}</td>
                            <td>${registro.grado_3}</td>
                            <td>${registro.grado_4}</td>
                            <td>${registro.grado_5}</td>
                            <td>${registro.grado_6}</td>
                            <td>${registro.grado_7}</td>
                            <td>${registro.grado_8}</td>
                            <td>${registro.grado_9}</td>
                            <td>${registro.grado_10}</td>
                            <td>${registro.grado_11}</td>
                            <td><strong>${registro.total_horas}</strong></td>
                            <td>
                                <button class="btn btn-warning btn-sm me-1" onclick="editarRegistro(${registro.id})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarRegistro(${registro.id})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
            
            $('#cuerpoTabla').html(html);
        }

        function editarRegistro(id) {
            $.ajax({
                url: 'obtener_registro.php',
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const registro = response.datos;
                        
                        // Llenar el formulario
                        $('#accion').val('editar');
                        $('#id_registro').val(registro.id);
                        $('#area').val(registro.area);
                        
                        // Cargar asignaturas del área y seleccionar la correcta
                        $('#area').trigger('change');
                        setTimeout(() => {
                            $('#asignatura').val(registro.asignatura);
                        }, 500);
                        
                        // Llenar horas por grado
                        for (let i = 1; i <= 11; i++) {
                            $('#grado_' + i).val(registro['grado_' + i]);
                        }
                        
                        calcularTotalHoras();
                        $('#intensidadModalLabel').text('Editar Intensidad Horaria');
                        $('#intensidadModal').modal('show');
                    }
                }
            });
        }

        function eliminarRegistro(id) {
            if (confirm('¿Está seguro de que desea eliminar este registro?')) {
                $.ajax({
                    url: 'eliminar_intensidad.php',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            cargarDatos();
                            mostrarAlerta('success', response.message);
                        } else {
                            mostrarAlerta('danger', response.message);
                        }
                    }
                });
            }
        }

        function exportarExcel() {
            window.open('exportar_intensidad_excel.php?id_cole=<?php echo $id_cole; ?>', '_blank');
        }

        function mostrarAlerta(tipo, mensaje) {
            const alertaHtml = `
                <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                    ${mensaje}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            `;
            
            $('.container-principal').prepend(alertaHtml);
            
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
        }

        // Reset modal al cerrarse
        $('#intensidadModal').on('hidden.bs.modal', function() {
            $('#formIntensidad')[0].reset();
            $('#accion').val('agregar');
            $('#id_registro').val('');
            $('#intensidadModalLabel').text('Configurar Intensidad Horaria');
            $('#asignatura').html('<option value="">── Primero seleccione un área ──</option>');
            calcularTotalHoras();
        });
    </script>

</body>
</html>