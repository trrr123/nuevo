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
    <title>Eliminar Período</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4 shadow-sm">
                    <h3 class="mb-3 text-center text-danger">Eliminar Período</h3>
                    
                    <?php if ($Periodo != null): ?>
                        <?php foreach ($Periodo as $Info): ?>
                            <div class="alert alert-warning mb-4">
                                <p class="mb-0"><strong>Período:</strong> <?php echo $Info['NOMBRE_PERIODO']; ?></p>
                                <p class="mb-0"><strong>Inicio:</strong> <?php echo date('d/m/Y', strtotime($Info['FECHA_INICIO'])); ?></p>
                                <p class="mb-0"><strong>Fin:</strong> <?php echo date('d/m/Y', strtotime($Info['FECHA_FIN'])); ?></p>
                            </div>

                            <p class="text-center mb-4">¿Estás seguro de que deseas eliminar este período?</p>
                            <p class="text-danger text-center"><small><strong>Advertencia:</strong> Se eliminarán todas las notas asociadas. Esta acción no se puede deshacer.</small></p>

                            <form action="../Controladores/delete.php" method="POST">
                                <input type="hidden" name="Id" value="<?php echo $Id; ?>">
                                
                                <div class="d-flex justify-content-between gap-2">
                                    <a href="index.php" class="btn btn-secondary flex-grow-1">Cancelar</a>
                                    <button type="submit" class="btn btn-danger flex-grow-1" name="Eliminar">Eliminar Período</button>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-danger">Período no encontrado</div>
                        <a href="index.php" class="btn btn-secondary w-100">Volver</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>