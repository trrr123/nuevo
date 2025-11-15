<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Administradores.php');

$ModeloUsuarios = new Usuarios();
$ModeloAdministradores = new Administradores();

$ModeloUsuarios->validateSession();

$Id = $_GET['Id'];
$Administrador = $ModeloAdministradores->getById($Id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h2 class="mb-4 text-center">Editar Administrador</h2>

                <form action="../Controladores/edit.php" method="POST" class="card p-4 shadow-sm">
                    <?php if ($Administrador != null): ?>
                        <?php foreach ($Administrador as $Info): ?>
                            <input type="hidden" name="Id" value="<?php echo $Id; ?>">

                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="Nombre" required autocomplete="off" value="<?php echo $Info['NOMBRE']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="Apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="Apellido" required autocomplete="off" value="<?php echo $Info['APELLIDO']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="Usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="Usuario" required autocomplete="off" value="<?php echo $Info['USUARIO']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="Password" required autocomplete="off" value="<?php echo $Info['PASSWORD']; ?>">
                            </div>

                            <div class="mb-4">
                                <label for="Estado" class="form-label">Estado</label>
                                <select name="Estado" class="form-select" required>
                                    <option value="<?php echo $Info['ESTADO']; ?>"><?php echo $Info['ESTADO']; ?></option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Editar</button> <br>
                            <button href="../Pages/index.php" class="btn btn-secondary">Cancelar</button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
