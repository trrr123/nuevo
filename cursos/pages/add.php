<?php
require_once('../../Usuarios/Modelo/Usuarios.php');
$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSessionAdministrador();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registrar Nuevo Curso</h2>
                        <form action="../Controladores/add.php" method="POST">
                            <div class="mb-3">
                                <label for="NombreCurso" class="form-label">Nombre del Curso</label>
                                <input type="text" class="form-control" name="NombreCurso" id="NombreCurso" required autocomplete="off" placeholder="Ej: Primero A, Segundo B">
                            </div>

                            <div class="mb-3">
                                <label for="Nivel" class="form-label">Nivel</label>
                                <select name="Nivel" id="Nivel" class="form-select" required>
                                    <option value="">-- Seleccione el nivel --</option>
                                    <option value="1">Primero</option>
                                    <option value="2">Segundo</option>
                                    <option value="3">Tercero</option>
                                    <option value="4">Cuarto</option>
                                    <option value="5">Quinto</option>
                                    <option value="6">Sexto</option>
                                    <option value="7">Séptimo</option>
                                    <option value="8">Octavo</option>
                                    <option value="9">Noveno</option>
                                    <option value="10">Décimo</option>
                                    <option value="11">Undécimo</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="Descripcion" id="Descripcion" rows="3" placeholder="Descripción del curso (opcional)"></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrar Curso</button>
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