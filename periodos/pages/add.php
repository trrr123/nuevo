<?php

require_once('../../Usuarios/Modelo/Usuarios.php');
$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSessionAdministrador();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Período</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registrar Nuevo Período</h2>
                        <form action="../Controladores/add.php" method="POST">
                            <div class="mb-3">
                                <label for="NombrePeriodo" class="form-label">Nombre del Período</label>
                                <input type="text" class="form-control" name="NombrePeriodo" id="NombrePeriodo" required autocomplete="off" placeholder="Ej: Período 1, Semestre 1">
                            </div>

                            <div class="mb-3">
                                <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" name="FechaInicio" id="FechaInicio" required>
                            </div>

                            <div class="mb-3">
                                <label for="FechaFin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" name="FechaFin" id="FechaFin" required>
                            </div>

                            <div class="mb-4">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="Descripcion" id="Descripcion" rows="3" placeholder="Descripción del período (opcional)"></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrar Período</button>
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>