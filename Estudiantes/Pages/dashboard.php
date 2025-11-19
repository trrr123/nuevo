<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Estudiantes.php');
require_once('../../notas/Modelo/Notas.php');

$ModeloUsuarios = new Usuarios();
$ModeloEstudiantes = new Estudiantes();
$ModeloNotas = new Notas();

$ModeloUsuarios->validateSession();

$IdEstudiante = $_GET['Id'] ?? null;
$Estudiante = [];
$CursosAsignados = [];
$NotasEstudiante = [];

if ($IdEstudiante) {
    $resultEstudiante = $ModeloEstudiantes->getById($IdEstudiante);
    if ($resultEstudiante) {
        $Estudiante = $resultEstudiante[0];
    }

    // Obtener cursos asignados del estudiante
 require_once(__DIR__ . '/../../mysqli_helper.php');
$conexion = getConnection();
    if ($conexion->connect_error) die("Error: " . $conexion->connect_error);

    $queryCursos = "SELECT c.ID_CURSO, c.NOMBRE_CURSO, c.NIVEL FROM estudiante_cursos ec 
                    INNER JOIN cursos c ON ec.ID_CURSO = c.ID_CURSO 
                    WHERE ec.ID_ESTUDIANTE = " . intval($IdEstudiante) . " AND ec.ESTADO = 'Activo'
                    ORDER BY c.NIVEL";
    $resultCursos = $conexion->query($queryCursos);
    if ($resultCursos->num_rows > 0) {
        while ($row = $resultCursos->fetch_assoc()) {
            $CursosAsignados[] = $row;
        }
    }

    $conexion->close();

    // Obtener notas del estudiante
    $NotasEstudiante = $ModeloNotas->obtenerNotasEstudiante($IdEstudiante);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Dashboard - Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav class="mb-4">
            <a href="#" class="btn btn-primary me-2">Mi Dashboard</a>
            <a href="../../Usuarios/Controladores/Salir.php" class="btn btn-danger">Salir</a>
        </nav>

        <?php if ($Estudiante): ?>
            <h3 class="mb-4">
                Bienvenido: <?php echo $Estudiante['NOMBRE'] . " " . $Estudiante['APELLIDO']; ?>
            </h3>

            <!-- Información del estudiante -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Documento</h5>
                            <h4><?php echo $Estudiante['DOCUMENTO']; ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Cursos Asignados</h5>
                            <h4><?php echo count($CursosAsignados); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Notas Registradas</h5>
                            <h4><?php echo count($NotasEstudiante) ?? 0; ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mis Cursos -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Mis Cursos</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($CursosAsignados)): ?>
                        <div class="row">
                            <?php foreach ($CursosAsignados as $Curso): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $Curso['NOMBRE_CURSO']; ?></h5>
                                        <p class="card-text">Nivel: <strong><?php echo $Curso['NIVEL']; ?></strong></p>
                                        <a href="#notas" class="btn btn-sm btn-primary">Ver Notas</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">
                            No tienes cursos asignados aún. Contacta al administrador.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mis Notas -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Mis Notas</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($NotasEstudiante)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Curso</th>
                                        <th>Materia</th>
                                        <th>Período</th>
                                        <th>Nota</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($NotasEstudiante as $Nota): ?>
                                    <tr>
                                        <td><?php echo $Nota['ID_CURSO']; ?></td>
                                        <td><?php echo $Nota['MATERIA']; ?></td>
                                        <td><?php echo $Nota['NOMBRE_PERIODO']; ?></td>
                                        <td>
                                            <strong>
                                                <?php 
                                                    $valor = floatval($Nota['VALOR_NOTA']);
                                                    echo number_format($valor, 1);
                                                    
                                                    if ($valor >= 3.0) {
                                                        echo ' <span class="badge bg-success">Aprobado</span>';
                                                    } else {
                                                        echo ' <span class="badge bg-danger">Reprobado</span>';
                                                    }
                                                ?>
                                            </strong>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($Nota['FECHA_REGISTRO'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            Aún no tienes notas registradas.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-danger">
                Error: No se encontró la información del estudiante. 
                <a href="../../index.php" class="btn btn-primary">Volver al inicio</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>