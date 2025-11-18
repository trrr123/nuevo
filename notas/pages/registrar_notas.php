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

if (!$IdCurso || !$IdPeriodo) {
    echo "<div class='alert alert-danger'>Error: Faltan parámetros IdCurso o IdPeriodo</div>";
    echo "<a href='index.php' class='btn btn-secondary'>Volver</a>";
    exit();
}

$Curso = $ModeloCursos->getById($IdCurso);
$Periodo = $ModeloPeriodos->getById($IdPeriodo);
$MateriasDelCurso = $ModeloCursos->obtenerMateriaCurso($IdCurso);

// Obtener estudiantes del curso
$conexion = new mysqli("localhost", "root", "", "notas");
if ($conexion->connect_error) {
    die("<div class='alert alert-danger'>Error de conexión: " . $conexion->connect_error . "</div>");
}

$queryEstudiantes = "SELECT DISTINCT e.ID_ESTUDIANTE, e.NOMBRE, e.APELLIDO 
                     FROM estudiantes e 
                     INNER JOIN estudiante_cursos ec ON e.ID_ESTUDIANTE = ec.ID_ESTUDIANTE 
                     WHERE ec.ID_CURSO = " . intval($IdCurso) . " 
                     AND ec.ESTADO = 'Activo'
                     ORDER BY e.NOMBRE";
$resultEstudiantes = $conexion->query($queryEstudiantes);
$Estudiantes = [];
if ($resultEstudiantes && $resultEstudiantes->num_rows > 0) {
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

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['mensaje']; 
                    unset($_SESSION['mensaje']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($Curso && $Periodo): ?>
            <?php foreach ($Curso as $C): ?>
                <?php foreach ($Periodo as $P): ?>
                    <div class="card mb-4 p-3">
                        <h5>Curso: <?php echo htmlspecialchars($C['NOMBRE_CURSO']); ?> - Período: <?php echo htmlspecialchars($P['NOMBRE_PERIODO']); ?></h5>
                        <p class="mb-0 text-muted">
                            <small>Docente: <?php echo htmlspecialchars($ModeloUsuarios->getNombre()); ?></small>
                        </p>
                    </div>

                    <?php if (empty($Estudiantes)): ?>
                        <div class="alert alert-warning">
                            <strong>No hay estudiantes asignados a este curso.</strong><br>
                            Por favor, contacta al administrador para asignar estudiantes al curso.
                        </div>
                        <a href="index.php" class="btn btn-secondary">Volver</a>
                    <?php elseif (empty($MateriasDelCurso)): ?>
                        <div class="alert alert-warning">
                            <strong>No hay materias asignadas a este curso.</strong><br>
                            Por favor, contacta al administrador para asignar materias al curso.
                        </div>
                        <a href="index.php" class="btn btn-secondary">Volver</a>
                    <?php else: ?>
                        <form method="POST" action="../Controladores/registrar.php" class="card p-4 shadow-sm">
                            <input type="hidden" name="IdCurso" value="<?php echo htmlspecialchars($IdCurso); ?>">
                            <input type="hidden" name="IdPeriodo" value="<?php echo htmlspecialchars($IdPeriodo); ?>">
                            <input type="hidden" name="IdDocente" value="<?php echo htmlspecialchars($ModeloUsuarios->getId()); ?>">

                            <div class="mb-3">
                                <label for="IdEstudiante" class="form-label">Estudiante *</label>
                                <select name="IdEstudiante" id="IdEstudiante" class="form-select" required>
                                    <option value="">-- Seleccione un Estudiante --</option>
                                    <?php 
                                    foreach ($Estudiantes as $Estudiante){
                                    ?>
                                    <option value="<?php echo $Estudiante['ID_ESTUDIANTE']; ?>">
                                        <?php echo htmlspecialchars($Estudiante['NOMBRE'] . " " . $Estudiante['APELLIDO']); ?>
                                    </option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="IdMateria" class="form-label">Materia *</label>
                                <select name="IdMateria" id="IdMateria" class="form-select" required>
                                    <option value="">-- Seleccione una Materia --</option>
                                    <?php 
                                    foreach ($MateriasDelCurso as $Materia){
                                    ?>
                                    <option value="<?php echo $Materia['ID_MATERIA']; ?>">
                                        <?php echo htmlspecialchars($Materia['MATERIA']); ?>
                                    </option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="Valor" class="form-label">Nota (0 - 100) *</label>
                                <input type="number" 
                                       name="Valor" 
                                       id="Valor" 
                                       class="form-control" 
                                       min="0" 
                                       max="100" 
                                       step="0.1" 
                                       required 
                                       placeholder="Ingrese la nota">
                                <div class="form-text">
                                    Ingrese una nota entre 0 y 100. Puede usar decimales (ejemplo: 85.5)
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <button type="submit" class="btn btn-success">Registrar Nota</button>
                                <a href="index.php?IdCurso=<?php echo $IdCurso; ?>&IdPeriodo=<?php echo $IdPeriodo; ?>" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-danger">
                <strong>Datos inválidos.</strong><br>
                No se encontró el curso o período seleccionado. Por favor, verifica los datos.
            </div>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>