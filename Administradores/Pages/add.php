<?php 
require_once('../../Usuarios/Modelo/Usuarios.php');
$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Administrador</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registrar Administrador</h2>
                        <form action="../Controladores/add.php" method="POST">
                            <div class="mb-3">
                                <label for="Nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="Nombre" id="Nombre" required autocomplete="off" placeholder="Nombre">
                            </div>

                            <div class="mb-3">
                                <label for="Apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="Apellido" id="Apellido" required autocomplete="off" placeholder="Apellido">
                            </div>

                            <div class="mb-3">
                                <label for="Usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="Usuario" id="Usuario" required autocomplete="off" placeholder="Usuario">
                            </div>

                            <div class="mb-4">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="Password" id="Password" required autocomplete="off" placeholder="Password">
                            </div>

                            <div class="d-grid">
                                <input type="submit" name="Registrar" value="Registrar" class="btn btn-primary"> <br>
                                <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='index.php'">
                                    Cancelar
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
