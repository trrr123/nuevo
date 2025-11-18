<?php
require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Periodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloPeriodos = new Periodos();

$ModeloUsuarios->validateSessionAdministrador();

$Id = $_GET['Id'];
$Periodo = $ModeloPeriodos->getById($Id);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Período</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h2 class="mb-4 text-center">Editar Período</h2>

                <form action="../Controladores/edit.php" method="POST" class="card p-4 shadow-sm">
                    <?php if ($Periodo != null): ?>
                        <?php foreach ($Periodo as $Info): ?>
                            <input type="hidden" name="Id" value="<?php echo $Id; ?>">

                            <div class="mb-3">
                                <label for="NombrePeriodo" class="form-label">Nombre del Período</label>
                                <input type="text" class="form-control" name="NombrePeriodo" required autocomplete="off" value="<?php echo $Info['NOMBRE_PERIODO']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" name="FechaInicio" required value="<?php echo $Info['FECHA_INICIO']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="FechaFin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" name="FechaFin" required value="<?php echo $Info['FECHA_FIN']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="Descripcion" rows="3"><?php echo $Info['DESCRIPCION']; ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="Estado" class="form-label">Estado</label>
                                <select name="Estado" class="form-select" required>
                                    <option value="<?php echo $Info['ESTADO']; ?>"><?php echo $Info['ESTADO']; ?></option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>