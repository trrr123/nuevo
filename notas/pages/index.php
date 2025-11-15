<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Notas.php');
require_once('../../Metodos.php');
require_once('../../cursos/Modelo/Cursos.php');
require_once('../../periodos/Modelo/Periodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloNotas = new Notas();
$ModeloMetodos = new Metodos();
$ModeloCursos = new Cursos();
$ModeloPeriodos = new Periodos();

$ModeloUsuarios->validateSession();

$IdCurso = isset($_GET['IdCurso']) ? $_GET['IdCurso'] : null;
$IdPeriodo = isset($_GET['IdPeriodo']) ? $_GET['IdPeriodo'] : null;

$Cursos = $ModeloCursos->get();
$Periodos = $ModeloPeriodos->get();
$Notas = [];

if ($IdCurso && $IdPeriodo) {
	$Notas = $ModeloNotas->obtenerNotasCursoDocente($IdCurso, $ModeloUsuarios->getId(), $IdPeriodo);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav class="mb-4">
            <a href="../../Estudiantes/Pages/index.php" class="btn btn-outline-primary me-2">Estudiantes</a>
            <a href="#" class="btn btn-primary me-2">Notas</a>
            <a href="../../Usuarios/Controladores/Salir.php" class="btn btn-danger">Salir</a>
        </nav>

        <h3 class="mb-3">
            Bienvenido: <?php echo $ModeloUsuarios->getNombre(); ?> - <?php echo $ModeloUsuarios->getPerfil(); ?>
        </h3>

        <!-- Filtros -->
        <div class="card mb-4 p-4">
            <h5 class="mb-3">Filtrar Notas</h5>
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="IdCurso" class="form-label">Seleccionar Curso</label>
                    <select name="IdCurso" id="IdCurso" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Seleccione un Curso --</option>
                        <?php 
                        if ($Cursos != null){
                            foreach ($Cursos as $Curso){
                        ?>
                        <option value="<?php echo $Curso['ID_CURSO']; ?>" <?php echo ($IdCurso == $Curso['ID_CURSO']) ? 'selected' : ''; ?>>
                            <?php echo $Curso['NOMBRE_CURSO'] . " (Nivel " . $Curso['NIVEL'] . ")"; ?>
                        </option>
                        <?php 
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-5">
                    <label for="IdPeriodo" class="form-label">Seleccionar Período</label>
                    <select name="IdPeriodo" id="IdPeriodo" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Seleccione un Período --</option>
                        <?php 
                        if ($Periodos != null){
                            foreach ($Periodos as $Periodo){
                        ?>
                        <option value="<?php echo $Periodo['ID_PERIODO']; ?>" <?php echo ($IdPeriodo == $Periodo['ID_PERIODO']) ? 'selected' : ''; ?>>
                            <?php echo $Periodo['NOMBRE_PERIODO']; ?>
                        </option>
                        <?php 
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>

        <?php if ($IdCurso && $IdPeriodo): ?>
            <a href="registrar_notas.php?IdCurso=<?php echo $IdCurso; ?>&IdPeriodo=<?php echo $IdPeriodo; ?>" class="btn btn-success mb-3">Registrar Nueva Nota</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Estudiante</th>
                            <th>Materia</th>
                            <th>Nota</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($Notas != null){
                            foreach ($Notas as $Nota){
                        ?>
                        <tr>
                            <td><?php echo $Nota['ID_NOTA'] ?></td>
                            <td><?php echo $Nota['NOMBRE'] . " " . $Nota['APELLIDO'] ?></td>
                            <td><?php echo $Nota['MATERIA'] ?></td>
                            <td><?php echo $Nota['VALOR_NOTA'] ?></td>
                            <td><?php echo date('d/m/Y', strtotime($Nota['FECHA_REGISTRO'])) ?></td>
                            <td>
                                <form method="POST" action="../Controladores/eliminar.php" style="display:inline;">
                                    <input type="hidden" name="IdNota" value="<?php echo $Nota['ID_NOTA']; ?>">
                                    <input type="hidden" name="IdCurso" value="<?php echo $IdCurso; ?>">
                                    <input type="hidden" name="IdPeriodo" value="<?php echo $IdPeriodo; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta nota?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No hay notas registradas</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Seleccione un curso y período para ver las notas</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>