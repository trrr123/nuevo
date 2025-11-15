<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Materia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h2 class="mb-4 text-center">Registrar Materia</h2>

                <form method="POST" action="../Controladores/add.php" class="card p-4 shadow-sm">
                    <div class="mb-3">
                        <label for="Nombre" class="form-label">Nombre de la Materia</label>
                        <input type="text" class="form-control" name="Nombre" id="Nombre" required autocomplete="off" placeholder="Nombre de la Materia">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Registrar Materia</button> <br>
                    <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='index.php'">
                                    Cancelar
                                </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
