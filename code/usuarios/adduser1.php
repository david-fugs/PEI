<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

header("Content-Type: text/html;charset=utf-8");
$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/popper.min.j"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
    <script>
        function ordenarSelect(id_componente) {
            var selectToSort = jQuery('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function(a, b) {
                return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
        }

        function toggleTipoUsuario() {
            var textoIE = $('#selectIE option:selected').text().toUpperCase();
            var esSecretaria = textoIE.indexOf('SECRETAR') !== -1;

            if (esSecretaria) {
                $('#bloque-tipo-normal').hide();
                $('#tipo_usuario_select').prop('disabled', true);
                $('#tipo_usuario_hidden').prop('disabled', false);
                $('#bloque-tipo-secretaria').show();
                $('#subtipo_usuario_select').prop('disabled', false).prop('required', true);
            } else {
                $('#bloque-tipo-normal').show();
                $('#tipo_usuario_select').prop('disabled', false);
                $('#tipo_usuario_hidden').prop('disabled', true);
                $('#bloque-tipo-secretaria').hide();
                $('#subtipo_usuario_select').prop('disabled', true).prop('required', false).val('');
            }
        }

        $(document).ready(function() {
            ordenarSelect('selectIE');
            toggleTipoUsuario();
            $('#selectIE').on('change', toggleTipoUsuario);
        });
    </script>
</head>

<body>
    <?php
    include("../../conexion.php");
    $id = $_GET['id'];
    if (isset($_GET['id'])) {
        $sql = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id = '$id'");
        $row = mysqli_fetch_array($sql);
    }
    ?>

    <div class="container">
        <center>
            <img src="../../img/gobersecre.png" width="400" height="188" class="responsive">
        </center>
        <BR />
        <h2><b>ACTUALIZAR INFORMACIÓN DEL USUARIO</b></h2>
        <p><i><b>
                    <font size=3 color=#c68615>*Datos obligatorios</i></b></font>
        </p>

        <form action='adduser2.php' method='post'>

            <div class="form-row">
                <label>
                    <input type="text" name="id" hidden readonly value="<?php echo $row['id']; ?>">
                </label>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="usuario">* USUARIO:</label>
                        <input type='text' name='usuario' class='form-control' value='<?php echo $row['usuario']; ?>' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="nombre">* NOMBRE DEL USUARIO:</label>
                        <input type='text' name='nombre' class='form-control' value='<?php echo utf8_encode($row['nombre']); ?>' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="id_cole">ESTABLECIMIENTO EDUCATIVO:</label>
                        <select name='id_cole' class='form-control' id="selectIE" readonly />
                        <option value=''></option>
                        <?php
                        header('Content-Type: text/html;charset=utf-8');
                        $consulta = 'SELECT * FROM colegios';
                        $res = mysqli_query($mysqli, $consulta);
                        $num_reg = mysqli_num_rows($res);
                        while ($row1 = $res->fetch_array()) {
                        ?>
                            <option value='<?php echo $row1['id_cole']; ?>' <?php if ($row['id_cole'] == $row1['id_cole']) {
                                                                                echo 'selected';
                                                                            } ?>>
                                <?php echo $row1['nombre_cole']; ?>
                            </option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="tipo_usuario">* TIPO DE USUARIO / PERFIL:</label>

                        <!-- Modo normal (IE distinta de Secretaría) -->
                        <div id="bloque-tipo-normal">
                            <select class="form-control" name="tipo_usuario" id="tipo_usuario_select" required>
                                <option value=""></option>
                                <option value="1" <?php if ($row['tipo_usuario'] == 1 && empty($row['subtipo_usuario'])) echo 'selected'; ?>>Administrador</option>
                                <option value="2" <?php if ($row['tipo_usuario'] == 2) echo 'selected'; ?>>I.E.</option>
                                <option value="3" <?php if ($row['tipo_usuario'] == 3) echo 'selected'; ?>>No validado</option>
                            </select>
                        </div>

                        <!-- Modo Secretaría de Educación -->
                        <div id="bloque-tipo-secretaria" style="display:none;">
                            <input type="hidden" name="tipo_usuario" id="tipo_usuario_hidden" value="1" disabled>
                            <select class="form-control" name="subtipo_usuario" id="subtipo_usuario_select">
                                <option value="">Seleccione perfil...</option>
                                <option value="Funcionario" <?php if ($row['subtipo_usuario'] === 'Funcionario') echo 'selected'; ?>>Funcionario</option>
                                <option value="Contratista" <?php if ($row['subtipo_usuario'] === 'Contratista') echo 'selected'; ?>>Contratista</option>
                            </select>
                            <small class="form-text text-muted">Ambos perfiles tienen rol de Administrador (nivel 1).</small>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-outline-warning" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                ACTUALIZAR INFORMACIÓN DEL USUARIO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>

</html>