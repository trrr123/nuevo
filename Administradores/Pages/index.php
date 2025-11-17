<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Administradores.php');

$ModeloUsuarios = new Usuarios();
$ModeloAdministradores = new Administradores();

$ModeloUsuarios->validateSessionAdministrador();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas - Administradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav class="mb-4">
            <a href="#" class="btn btn-primary me-2">Administradores</a>
            <a href="../../Docentes/Pages/index.php" class="btn btn-outline-primary me-2">Docentes</a>
            <a href="../../Materias/Pages/index.php" class="btn btn-outline-primary me-2">Materias</a>
            <a href="../../cursos/Pages/index.php" class="btn btn-outline-primary me-2">Cursos</a>
            <a href="../../periodos/Pages/index.php" class="btn btn-outline-primary me-2">Períodos</a>
            <a href="../../Estudiantes/Pages/index.php" class="btn btn-outline-primary me-2">Estudiantes</a>
            <a href="../../Usuarios/Controladores/Salir.php" class="btn btn-danger">Salir</a>
        </nav>

        <h3 class="mb-3">
            Bienvenido: <?php echo $ModeloUsuarios->getNombre(); ?> - <?php echo $ModeloUsuarios->getPerfil(); ?>
        </h3>

        <a href="add.php" class="btn btn-success mb-3">Registrar nuevo Administrador</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $Administradores = $ModeloAdministradores->get();
                    if ($Administradores != null){
                        foreach ($Administradores as $Administrador){
                    ?>
                    <tr>
                        <td><?php echo $Administrador['ID_USUARIO'] ?></td>
                        <td><?php echo $Administrador['NOMBRE'] ?></td>
                        <td><?php echo $Administrador['APELLIDO'] ?></td>
                        <td><?php echo $Administrador['USUARIO'] ?></td>
                        <td><?php echo $Administrador['PERFIL'] ?></td>
                        <td><?php echo $Administrador['ESTADO'] ?></td>
                        <td>
                            <a href="edit.php?Id=<?php echo $Administrador['ID_USUARIO'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="delete.php?Id=<?php echo $Administrador['ID_USUARIO'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
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