
<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Notas.php');
require_once('../../cursos/Modelo/Cursos.php');
require_once('../../periodos/Modelo/Periodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloNotas = new Notas();
$ModeloCursos = new Cursos();
$ModeloPeriodos = new Periodos();

$ModeloUsuarios->validateSession();

$IdCurso = isset($_GET['IdCurso']) ? $_GET['IdCurso'] : null;
$IdPeriodo = isset($_GET['IdPeriodo']) ? $_GET['IdPeriodo'] : null;

$Curso = $ModeloCursos->getById($IdCurso);
$Periodo = $ModeloPeriodos->getById($IdPeriodo);
$MateriasDelCurso = $ModeloCursos->obtenerMateriaCurso($IdCurso);

// Obtener estudiantes del curso (necesitamos tabla estudiante_cursos)
$conexion = new mysqli("localhost", "root", "", "notas");
if ($conexion->connect_error) die("Error: " . $conexion->connect_error);

$queryEstudiantes = "SELECT DISTINCT e.ID_ESTUDIANTE, e.NOMBRE, e.APELLIDO FROM estudiantes e 
                     INNER JOIN estudiante_cursos ec ON e.ID_ESTUDIANTE = ec.ID_ESTUDIANTE 
                     WHERE ec.ID_CURSO = " . intval($IdCurso) . " 
                     ORDER BY e.NOMBRE";
$resultEstudiantes = $conexion->query($queryEstudiantes);
$Estudiantes = [];
if ($resultEstudiantes->num_rows > 0) {
    while ($row = $resultEstudiantes->fetch_assoc()) {
        $Estudiantes[] = $row;
    }
}
$conexion->close();

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
        <h2 class="mb-4">Registrar Notas</h2>

        <?php if ($Curso && $Periodo): ?>
            <?php foreach ($Curso as $C): ?>
                <?php foreach ($Periodo as $P): ?>
                    <div class="card mb-4 p-3">
                        <h5>Curso: <?php echo $C['NOMBRE_CURSO']; ?> - Período: <?php echo $P['NOMBRE_PERIODO']; ?></h5>
                    </div>

                    <form method="POST" action="../Controladores/registrar.php" class="card p-4 shadow-sm">
                        <input type="hidden" name="IdCurso" value="<?php echo $IdCurso; ?>">
                        <input type="hidden" name="IdPeriodo" value="<?php echo $IdPeriodo; ?>">
                        <input type="hidden" name="IdDocente" value="<?php echo $ModeloUsuarios->getId(); ?>">

                        <div class="mb-3">
                            <label for="IdEstudiante" class="form-label">Estudiante</label>
                            <select name="IdEstudiante" id="IdEstudiante" class="form-select" required onchange="cargarMaterias()">
                                <option value="">-- Seleccione un Estudiante --</option>
                                <?php 
                                foreach ($Estudiantes as $Estudiante){
                                ?>
                                <option value="<?php echo $Estudiante['ID_ESTUDIANTE']; ?>">
                                    <?php echo $Estudiante['NOMBRE'] . " " . $Estudiante['APELLIDO']; ?>
                                </option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="IdMateria" class="form-label">Materia</label>
                            <select name="IdMateria" id="IdMateria" class="form-select" required>
                                <option value="">-- Seleccione una Materia --</option>
                                <?php 
                                if ($MateriasDelCurso != null){
                                    foreach ($MateriasDelCurso as $Materia){
                                ?>
                                <option value="<?php echo $Materia['ID_MATERIA']; ?>">
                                    <?php echo $Materia['MATERIA']; ?>
                                </option>
                                <?php 
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="Valor" class="form-label">Nota (0 - 100)</label>
                            <input type="number" name="Valor" id="Valor" class="form-control" min="0" max="100" step="0.5" required placeholder="Ingrese la nota">
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <button type="submit" class="btn btn-success">Registrar Nota</button>
                            <a href="index.php?IdCurso=<?php echo $IdCurso; ?>&IdPeriodo=<?php echo $IdPeriodo; ?>" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning">Datos inválidos. Por favor, seleccione un curso y período.</div>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>