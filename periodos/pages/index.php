<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Periodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloPeriodos = new Periodos();

$ModeloUsuarios->validateSessionAdministrador();

$Periodos = $ModeloPeriodos->get();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas - Períodos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav class="mb-4">
            <a href="../../Administradores/Pages/index.php" class="btn btn-outline-primary me-2">Administradores</a>
            <a href="../../Docentes/Pages/index.php" class="btn btn-outline-primary me-2">Docentes</a>
            <a href="../../Materias/Pages/index.php" class="btn btn-outline-primary me-2">Materias</a>
            <a href="../../cursos/Pages/index.php" class="btn btn-outline-primary me-2">Cursos</a>
            <a href="#" class="btn btn-primary me-2">Períodos</a>
            <a href="../../Estudiantes/Pages/index.php" class="btn btn-outline-primary me-2">Estudiantes</a>
            <a href="../../Usuarios/Controladores/Salir.php" class="btn btn-danger">Salir</a>
        </nav>

        <h3 class="mb-3">
            Bienvenido: <?php echo $ModeloUsuarios->getNombre(); ?> - <?php echo $ModeloUsuarios->getPerfil(); ?>
        </h3>

        <a href="add.php" class="btn btn-success mb-3">Registrar Nuevo Período</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre Período</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($Periodos != null){
                        foreach ($Periodos as $Periodo){
                    ?>
                    <tr>
                        <td><?php echo $Periodo['ID_PERIODO'] ?></td>
                        <td><?php echo $Periodo['NOMBRE_PERIODO'] ?></td>
                        <td><?php echo date('d/m/Y', strtotime($Periodo['FECHA_INICIO'])) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($Periodo['FECHA_FIN'])) ?></td>
                        <td><?php echo $Periodo['ESTADO'] ?></td>
                        <td>
                            <a href="edit.php?Id=<?php echo $Periodo['ID_PERIODO'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="delete.php?Id=<?php echo $Periodo['ID_PERIODO'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>