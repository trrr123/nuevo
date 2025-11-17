<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Docentes.php');

$ModeloUsuarios = new Usuarios();
$ModeloDocentes = new Docentes();

$ModeloUsuarios->validateSession();

$IdDocente = $ModeloUsuarios->getId();
$MateriasAsignadas = $ModeloDocentes->obtenerMateriasDocente($IdDocente);
$CursosDocente = $ModeloDocentes->obtenerCursosDocente($IdDocente);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav class="mb-4">
            <a href="#" class="btn btn-primary me-2">Mi Dashboard</a>
            <a href="../../Estudiantes/Pages/index.php" class="btn btn-outline-primary me-2">Estudiantes</a>
            <a href="../../notas/pages/index.php" class="btn btn-outline-primary me-2">Registrar Notas</a>
            <a href="../../Usuarios/Controladores/Salir.php" class="btn btn-danger">Salir</a>
        </nav>

        <h3 class="mb-4">
            Bienvenido: <?php echo $ModeloUsuarios->getNombre(); ?> - <?php echo $ModeloUsuarios->getPerfil(); ?>
        </h3>

        <!-- Resumen rápido -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Cursos Asignados</h5>
                        <h2><?php echo $CursosDocente ? count($CursosDocente) : 0; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Materias Asignadas</h5>
                        <h2><?php echo $MateriasAsignadas ? count($MateriasAsignadas) : 0; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Acciones Rápidas</h5>
                        <a href="../../notas/pages/index.php" class="btn btn-light btn-sm mt-2">Registrar Notas</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mis materias asignadas -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Mis Materias Asignadas</h5>
            </div>
            <div class="card-body">
                <?php if ($MateriasAsignadas != null): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
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
                                        <a href="../../notas/pages/index.php?IdCurso=<?php echo $Materia['ID_CURSO']; ?>" class="btn btn-primary btn-sm">Ver Notas</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <strong>No tienes materias asignadas.</strong><br>
                        Por favor, contacta al administrador para que te asigne materias y cursos.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mis cursos -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Mis Cursos</h5>
            </div>
            <div class="card-body">
                <?php if ($CursosDocente != null): ?>
                    <div class="row">
                        <?php foreach ($CursosDocente as $Curso): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $Curso['NOMBRE_CURSO']; ?></h5>
                                    <p class="card-text">Nivel: <?php echo $Curso['NIVEL']; ?></p>
                                    <a href="../../notas/pages/index.php?IdCurso=<?php echo $Curso['ID_CURSO']; ?>" class="btn btn-primary btn-sm">Ver Estudiantes</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No tienes cursos asignados.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>