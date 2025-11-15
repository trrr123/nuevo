<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Materias.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSessionAdministrador();

$Modelo = new Materias();
$Materias = $Modelo->get();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas - Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav class="mb-4">
            <a href="../../Administradores/Pages/index.php" class="btn btn-outline-primary me-2">Administradores</a>
            <a href="../../Docentes/Pages/index.php" class="btn btn-outline-primary me-2">Docentes</a>
            <a href="#" class="btn btn-primary me-2">Materias</a>
            <a href="../../Estudiantes/Pages/index.php" class="btn btn-outline-primary me-2">Estudiantes</a>
            <a href="../../Usuarios/Controladores/Salir.php" class="btn btn-danger">Salir</a>
        </nav>

        <h3 class="mb-3">
            Bienvenido: <?php echo $ModeloUsuarios->getNombre(); ?> - <?php echo $ModeloUsuarios->getPerfil(); ?>
        </h3>

        <a href="add.php" class="btn btn-success mb-3">Registrar Materia</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($Materias != null){
                        foreach ($Materias as $Materia) {
                    ?>
                    <tr>
                        <td><?php echo $Materia['ID_MATERIA'] ?></td>
                        <td><?php echo $Materia['MATERIA'] ?></td>
                        <td>
                            <a href="edit.php?Id=<?php echo $Materia['ID_MATERIA'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="delete.php?Id=<?php echo $Materia['ID_MATERIA'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
</body>
</html>
