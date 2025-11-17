<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Docentes.php');
require_once('../../Materias/Modelo/Materias.php');
require_once('../../cursos/modelo/cursos.php');

$ModeloUsuarios = new Usuarios();
$ModeloDocentes = new Docentes();
$ModeloMaterias = new Materias();
$ModeloCursos = new Cursos();

$ModeloUsuarios->validateSessionAdministrador();

$IdDocente = $_GET['Id'];
$Docente = $ModeloDocentes->getById($IdDocente);
$MateriasAsignadas = $ModeloDocentes->obtenerMateriasDocente($IdDocente);
$TodasLasMaterias = $ModeloMaterias->get();
$TodosLosCursos = $ModeloCursos->get();

$error = isset($_GET['error']) ? $_GET['error'] : '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Materias al Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Asignar Materias al Docente</h2>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">Esta materia ya está asignada a este docente en este curso.</div>
        <?php endif; ?>

        <?php if ($Docente != null): ?>
            <?php foreach ($Docente as $Info): ?>
                <div class="card mb-4 p-3">
                    <h5>Docente: <?php echo $Info['NOMBRE'] . " " . $Info['APELLIDO']; ?></h5>
                </div>

                <!-- Formulario para asignar nueva materia -->
                <div class="card mb-4 p-4">
                    <h5 class="mb-3">Asignar Nueva Materia</h5>
                    <form method="POST" action="../Controladores/asignar_materia.php">
                        <input type="hidden" name="IdDocente" value="<?php echo $IdDocente; ?>">
                        
                        <div class="row">
                            <div class="col-md-5 mb-3">
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

                            <div class="col-md-5 mb-3">
                                <label class="form-label">Materia</label>
                                <select name="IdMateria" class="form-select" required>
                                    <option value="">-- Seleccione una Materia --</option>
                                    <?php 
                                    if ($TodasLasMaterias != null){
                                        foreach ($TodasLasMaterias as $Materia){
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

                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Asignar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Lista de materias asignadas -->
                <div class="card p-4">
                    <h5 class="mb-3">Materias Asignadas</h5>
                    
                    <?php if ($MateriasAsignadas != null): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Curso</th>
                                        <th>Nivel</th>
                                        <th>Materia</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($MateriasAsignadas as $Materia): ?>
                                    <tr>
                                        <td><?php echo $Materia['NOMBRE_CURSO']; ?></td>
                                        <td><?php echo $Materia['NIVEL']; ?></td>
                                        <td><?php echo $Materia['MATERIA']; ?></td>
                                        <td>
                                            <form method="POST" action="../Controladores/eliminar_materia.php" style="display:inline;">
                                                <input type="hidden" name="Id" value="<?php echo $Materia['ID']; ?>">
                                                <input type="hidden" name="IdDocente" value="<?php echo $IdDocente; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No hay materias asignadas a este docente.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>