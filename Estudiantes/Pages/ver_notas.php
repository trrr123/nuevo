<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Estudiantes.php');
require_once('../../notas/Modelo/Notas.php');
require_once('../../Docentes/Modelo/Docentes.php');
require_once('../../periodos/Modelo/Periodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloEstudiantes = new Estudiantes();
$ModeloNotas = new Notas();
$ModeloDocentes = new Docentes();
$ModeloPeriodos = new Periodos();

$ModeloUsuarios->validateSession();

$IdEstudiante = $_GET['Id'] ?? null;
$IdDocente = $ModeloUsuarios->getId();

if (!$IdEstudiante) {
    echo "<div class='alert alert-danger'>Error: Falta el ID del estudiante</div>";
    exit();
}

// Obtener información del estudiante
$Estudiante = $ModeloEstudiantes->getById($IdEstudiante);
if (!$Estudiante) {
    echo "<div class='alert alert-danger'>Error: Estudiante no encontrado</div>";
    exit();
}

// Obtener cursos del estudiante
$conexion = new mysqli("localhost", "root", "", "notas");
if ($conexion->connect_error) die("Error: " . $conexion->connect_error);

$queryCursos = "SELECT DISTINCT c.ID_CURSO, c.NOMBRE_CURSO, c.NIVEL 
                FROM estudiante_cursos ec 
                INNER JOIN cursos c ON ec.ID_CURSO = c.ID_CURSO 
                WHERE ec.ID_ESTUDIANTE = " . intval($IdEstudiante) . " 
                AND ec.ESTADO = 'Activo'";
$resultCursos = $conexion->query($queryCursos);
$CursosEstudiante = [];
if ($resultCursos && $resultCursos->num_rows > 0) {
    while ($row = $resultCursos->fetch_assoc()) {
        $CursosEstudiante[] = $row;
    }
}
$conexion->close();

// Obtener materias del docente que están en los cursos del estudiante
$MateriasDisponibles = [];
$MateriasDocente = $ModeloDocentes->obtenerMateriasDocente($IdDocente);

if ($MateriasDocente && !empty($CursosEstudiante)) {
    foreach ($MateriasDocente as $Materia) {
        // Verificar si el docente da esta materia en algún curso del estudiante
        foreach ($CursosEstudiante as $Curso) {
            if ($Materia['ID_CURSO'] == $Curso['ID_CURSO']) {
                // Evitar duplicados
                $yaExiste = false;
                foreach ($MateriasDisponibles as $md) {
                    if ($md['ID_MATERIA'] == $Materia['ID_MATERIA'] && $md['ID_CURSO'] == $Materia['ID_CURSO']) {
                        $yaExiste = true;
                        break;
                    }
                }
                if (!$yaExiste) {
                    $MateriasDisponibles[] = $Materia;
                }
            }
        }
    }
}

// Obtener períodos
$Periodos = $ModeloPeriodos->get();

// Obtener notas del estudiante
$NotasEstudiante = $ModeloNotas->obtenerNotasEstudiante($IdEstudiante);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas del Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Notas del Estudiante</h2>
            <a href="index.php" class="btn btn-secondary">← Volver</a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Información del estudiante -->
        <?php foreach ($Estudiante as $Info): ?>
            <div class="card mb-4 p-3 bg-light">
                <h4><?php echo $Info['NOMBRE'] . " " . $Info['APELLIDO']; ?></h4>
                <p class="mb-0">
                    <strong>Documento:</strong> <?php echo $Info['DOCUMENTO']; ?> | 
                    <strong>Correo:</strong> <?php echo $Info['CORREO']; ?> |
                    <strong>Promedio Actual:</strong> <span class="badge bg-info"><?php echo $Info['PROMEDIO']; ?></span>
                </p>
            </div>

            <!-- Información de materias disponibles -->
            <?php if (!empty($MateriasDisponibles)): ?>
            <div class="alert alert-info mb-4">
                <strong>📚 Tus materias en cursos de este estudiante:</strong><br>
                <ul class="mb-0 mt-2">
                    <?php 
                    foreach ($MateriasDisponibles as $md): 
                    ?>
                        <li><?php echo $md['MATERIA']; ?> - <?php echo $md['NOMBRE_CURSO']; ?> (Nivel <?php echo $md['NIVEL']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
                <small class="text-muted">Solo puedes registrar notas para estas combinaciones de materia-curso.</small>
            </div>
            <?php endif; ?>

            <!-- Formulario para agregar nueva nota -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">➕ Registrar Nueva Nota</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($CursosEstudiante)): ?>
                        <div class="alert alert-warning">
                            Este estudiante no tiene cursos asignados. No se pueden registrar notas.
                        </div>
                    <?php elseif (empty($MateriasDisponibles)): ?>
                        <div class="alert alert-warning">
                            <strong>No puedes registrar notas para este estudiante.</strong><br>
                            Razones posibles:<br>
                            - No tienes materias asignadas en los cursos donde está este estudiante<br>
                            - El estudiante no está en ninguno de tus cursos<br>
                            Contacta al administrador si crees que esto es un error.
                        </div>
                    <?php elseif (empty($Periodos)): ?>
                        <div class="alert alert-warning">
                            No hay períodos registrados. Contacta al administrador.
                        </div>
                    <?php else: ?>
                        <form method="POST" action="../../notas/Controladores/registrar.php">
                            <input type="hidden" name="IdEstudiante" value="<?php echo $IdEstudiante; ?>">
                            <input type="hidden" name="IdDocente" value="<?php echo $IdDocente; ?>">
                            <input type="hidden" name="redirect" value="ver_notas">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Materia (solo tus cursos) *</label>
                                    <select name="IdMateria" id="IdMateria" class="form-select" required onchange="filtrarCursos()">
                                        <option value="">-- Seleccione Materia --</option>
                                        <?php 
                                        // Agrupar por materia para evitar duplicados en el select
                                        $materiasUnicas = [];
                                        foreach ($MateriasDisponibles as $Materia) {
                                            if (!isset($materiasUnicas[$Materia['ID_MATERIA']])) {
                                                $materiasUnicas[$Materia['ID_MATERIA']] = $Materia;
                                            }
                                        }
                                        foreach ($materiasUnicas as $Materia): 
                                        ?>
                                            <option value="<?php echo $Materia['ID_MATERIA']; ?>">
                                                <?php echo $Materia['MATERIA']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Curso (donde das esta materia) *</label>
                                    <select name="IdCurso" id="IdCurso" class="form-select" required>
                                        <option value="">-- Primero selecciona Materia --</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Período *</label>
                                    <select name="IdPeriodo" class="form-select" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php foreach ($Periodos as $Periodo): ?>
                                            <?php if ($Periodo['ESTADO'] == 'Activo'): ?>
                                                <option value="<?php echo $Periodo['ID_PERIODO']; ?>">
                                                    <?php echo $Periodo['NOMBRE_PERIODO']; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Nota (0-100) *</label>
                                    <input type="number" 
                                           name="Valor" 
                                           class="form-control" 
                                           min="0" 
                                           max="100" 
                                           step="0.1" 
                                           required 
                                           placeholder="0.0">
                                </div>

                                <div class="col-md-1 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">
                                        ✓ Guardar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <script>
                        // JavaScript para filtrar cursos según la materia seleccionada
                        const materiasDisponibles = <?php echo json_encode($MateriasDisponibles); ?>;
                        
                        function filtrarCursos() {
                            const materiaSelect = document.getElementById('IdMateria');
                            const cursoSelect = document.getElementById('IdCurso');
                            const materiaId = materiaSelect.value;
                            
                            // Limpiar opciones de curso
                            cursoSelect.innerHTML = '<option value="">-- Seleccione Curso --</option>';
                            
                            if (materiaId) {
                                // Filtrar cursos donde el docente da esta materia
                                const cursosParaMateria = materiasDisponibles.filter(m => m.ID_MATERIA == materiaId);
                                
                                cursosParaMateria.forEach(materia => {
                                    const option = document.createElement('option');
                                    option.value = materia.ID_CURSO;
                                    option.textContent = materia.NOMBRE_CURSO + ' (Nivel ' + materia.NIVEL + ')';
                                    cursoSelect.appendChild(option);
                                });
                            }
                        }
                        </script>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Historial de notas -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">📊 Historial de Notas</h5>
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
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($NotasEstudiante as $Nota): ?>
                                    <tr>
                                        <td><?php echo $Nota['ID_CURSO']; ?></td>
                                        <td><?php echo $Nota['MATERIA']; ?></td>
                                        <td><?php echo $Nota['NOMBRE_PERIODO']; ?></td>
                                        <td>
                                            <strong><?php echo number_format($Nota['VALOR_NOTA'], 1); ?></strong>
                                        </td>
                                        <td>
                                            <?php 
                                            $valor = floatval($Nota['VALOR_NOTA']);
                                            if ($valor >= 3.0) {
                                                echo '<span class="badge bg-success">Aprobado</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">Reprobado</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($Nota['FECHA_REGISTRO'])); ?></td>
                                        <td>
                                            <?php 
                                            // Solo permitir eliminar si el docente actual registró esta nota
                                            // Y si el docente tiene asignada esa materia en ese curso
                                            $puedeEliminar = false;
                                            if ($Nota['ID_DOCENTE'] == $IdDocente) {
                                                foreach ($MateriasDisponibles as $md) {
                                                    if ($md['ID_MATERIA'] == $Nota['ID_MATERIA'] && 
                                                        $md['ID_CURSO'] == $Nota['ID_CURSO']) {
                                                        $puedeEliminar = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            
                                            if ($puedeEliminar): 
                                            ?>
                                                <form method="POST" action="../../notas/Controladores/eliminar.php" style="display:inline;">
                                                    <input type="hidden" name="IdNota" value="<?php echo $Nota['ID_NOTA']; ?>">
                                                    <input type="hidden" name="IdEstudiante" value="<?php echo $IdEstudiante; ?>">
                                                    <input type="hidden" name="IdCurso" value="<?php echo $Nota['ID_CURSO']; ?>">
                                                    <input type="hidden" name="IdPeriodo" value="<?php echo $Nota['ID_PERIODO']; ?>">
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('¿Eliminar esta nota?')">
                                                        🗑️ Eliminar
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted" title="Solo puedes eliminar notas de tus materias/cursos asignados">🔒</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            📝 Aún no hay notas registradas para este estudiante.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>