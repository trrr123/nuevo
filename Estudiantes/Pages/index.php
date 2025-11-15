<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Estudiantes.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

$Modelo = new Estudiantes();
$Materias = $Modelo->get();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <!-- Menú de navegación -->
    <nav class="mb-4">
        <div class="btn-group" role="group">
            <?php if ($ModeloUsuarios->getPerfil() == 'Docente') { ?>
                <a class="btn btn-outline-primary" href="#">Estudiantes</a>
            <?php } else { ?>
                <a class="btn btn-outline-primary" href="../../Administradores/Pages/index.php">Administradores</a>
                <a class="btn btn-outline-primary" href="../../Docentes/Pages/index.php">Docentes</a>
                <a class="btn btn-outline-primary" href="../../Materias/Pages/index.php">Materias</a>
                <a class="btn btn-primary" href="#">Estudiantes</a>
            <?php } ?>
            <a class="btn btn-danger" href="../../Usuarios/Controladores/Salir.php">Salir</a>
        </div>
    </nav>

    <!-- Bienvenida -->
    <div class="mb-3">
        <h4>Bienvenido: <strong><?php echo $ModeloUsuarios->getNombre(); ?></strong> - <?php echo $ModeloUsuarios->getPerfil(); ?></h4>
        <a class="btn btn-success mt-2" href="add.php">Registrar Estudiante</a>
    </div>

    <!-- Tabla de estudiantes -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Promedio</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $Estudiantes = $Modelo->get();
                if ($Estudiantes != null){
                    foreach ($Estudiantes as $Estudiante) {
                ?>
                <tr>
                    <td><?php echo $Estudiante['ID_ESTUDIANTE'] ?></td>
                    <td><?php echo $Estudiante['NOMBRE'] ?></td>
                    <td><?php echo $Estudiante['APELLIDO'] ?></td>
                    <td><?php echo $Estudiante['DOCUMENTO'] ?></td>
                    <td><?php echo $Estudiante['CORREO'] ?></td>
                    <td><?php echo $Estudiante['MATERIA'] ?></td>
                    <td><?php echo $Estudiante['DOCENTE'] ?></td>
                    <td><?php echo $Estudiante['PROMEDIO'] ?></td>
                    <td><?php echo $Estudiante['FECHA_REGISTRO'] ?></td>
                    <td>
                        <a href="edit.php?Id=<?php echo $Estudiante['ID_ESTUDIANTE'] ?>" class="btn btn-sm btn-warning mb-1">Editar</a>
                        <a href="delete.php?Id=<?php echo $Estudiante['ID_ESTUDIANTE'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
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
