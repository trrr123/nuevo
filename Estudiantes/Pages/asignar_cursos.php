<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Estudiantes.php');
require_once('../../cursos/Modelo/Cursos.php');

$ModeloUsuarios = new Usuarios();
$ModeloEstudiantes = new Estudiantes();
$ModeloCursos = new Cursos();

$ModeloUsuarios->validateSessionAdministrador();

$IdEstudiante = $_GET['Id'];
$Estudiante = $ModeloEstudiantes->getById($IdEstudiante);
$TodosLosCursos = $ModeloCursos->get();

// Obtener cursos ya asignados
$conexion = new mysqli("localhost", "root", "", "notas");
if ($conexion->connect_error) die("Error: " . $conexion->connect_error);

$queryCursosAsignados = "SELECT ec.ID, c.ID_CURSO, c.NOMBRE_CURSO, c.NIVEL FROM estudiante_cursos ec 
                         INNER JOIN cursos c ON ec.ID_CURSO = c.ID_CURSO 
                         WHERE ec.ID_ESTUDIANTE = " . intval($IdEstudiante) . " AND ec.ESTADO = 'Activo'
                         ORDER BY c.NIVEL";
$resultCursosAsignados = $conexion->query($queryCursosAsignados);
$CursosAsignados = [];
if ($resultCursosAsignados->num_rows > 0) {
    while ($row = $resultCursosAsignados->fetch_assoc()) {
        $CursosAsignados[] = $row;
    }
}

$error = isset($_GET['error']) ? $_GET['error'] : '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Cursos al Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Asignar Cursos al Estudiante</h2>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">Error al asignar el curso. Intenta de nuevo.</div>
        <?php endif; ?>

        <?php if ($Estudiante != null): ?>
            <?php foreach ($Estudiante as $Info): ?>
                <div class="card mb-4 p-3">
                    <h5>Estudiante: <?php echo $Info['NOMBRE'] . " " . $Info['APELLIDO']; ?></h5>
                    <p class="mb-0"><small>Documento: <?php echo $Info['DOCUMENTO']; ?></small></p>
                </div>

                <!-- Formulario para asignar nuevo curso -->
                <div class="card mb-4 p-4">
                    <h5 class="mb-3">Asignar Nuevo Curso</h5>
                    <form method="POST" action="../Controladores/asignar_curso.php">
                        <input type="hidden" name="IdEstudiante" value="<?php echo $IdEstudiante; ?>">
                        
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <label class="form-label">Curso</label>
                                <select name="IdCurso" class="form-select" required>
                                    <option value="">-- Seleccione un Curso --</option>
                                    <?php 
                                    if ($TodosLosCursos != null){
                                        foreach ($TodosLosCursos as $Curso){
                                    ?>
                                    <option value="<?php echo $Curso['ID_CURSO']; ?>">
                                        <?php echo $Curso['NOMBRE_CURSO'] . " (Nivel " . $Curso['NIVEL'] . ")"; ?>
                                    </option>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Asignar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Lista de cursos asignados -->
                <div class="card p-4">
                    <h5 class="mb-3">Cursos Asignados</h5>
                    
                    <?php if (!empty($CursosAsignados)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Curso</th>
                                        <th>Nivel</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($CursosAsignados as $Curso): ?>
                                    <tr>
                                        <td><?php echo $Curso['NOMBRE_CURSO']; ?></td>
                                        <td><?php echo $Curso['NIVEL']; ?></td>
                                        <td>
                                            <form method="POST" action="../Controladores/desasignar_curso.php" style="display:inline;">
                                                <input type="hidden" name="Id" value="<?php echo $Curso['ID']; ?>">
                                                <input type="hidden" name="IdEstudiante" value="<?php echo $IdEstudiante; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desasignar este curso?')">Desasignar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No hay cursos asignados a este estudiante.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conexion->close(); ?>