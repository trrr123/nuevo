<?php
require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Cursos.php');

$ModeloUsuarios = new Usuarios();
$ModeloCursos = new Cursos();

$ModeloUsuarios->validateSessionAdministrador();

$Id = $_GET['Id'];
$Curso = $ModeloCursos->getById($Id);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4 shadow-sm">
                    <h3 class="mb-3 text-center text-danger">Eliminar Curso</h3>
                    
                    <?php if ($Curso != null): ?>
                        <?php foreach ($Curso as $Info): ?>
                            <div class="alert alert-warning mb-4">
                                <p class="mb-0"><strong>Curso:</strong> <?php echo $Info['NOMBRE_CURSO']; ?></p>
                                <p class="mb-0"><strong>Nivel:</strong> <?php echo $Info['NIVEL']; ?></p>
                            </div>

                            <p class="text-center mb-4">¿Estás seguro de que deseas eliminar este curso?</p>
                            <p class="text-danger text-center"><small><strong>Advertencia:</strong> Esta acción no se puede deshacer.</small></p>

                            <form action="../Controladores/delete.php" method="POST">
                                <input type="hidden" name="Id" value="<?php echo $Id; ?>">
                                
                                <div class="d-flex justify-content-between gap-2">
                                    <a href="index.php" class="btn btn-secondary flex-grow-1">Cancelar</a>
                                    <button type="submit" class="btn btn-danger flex-grow-1" name="Eliminar">Eliminar Curso</button>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-danger">Curso no encontrado</div>
                        <a href="index.php" class="btn btn-secondary w-100">Volver</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>