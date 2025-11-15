<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Materias.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

$Modelo = new Materias();
$Id = $_GET['Id'];
$InformacionMateria = $Modelo->getById($Id);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Materia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="mb-4 text-center">Editar Materia</h2>

            <form method="POST" action="../Controladores/edit.php" class="card p-4 shadow-sm">
                <input type="hidden" name="Id" value="<?php echo $Id ?>">

                <?php if ($InformacionMateria != null): ?>
                    <?php foreach ($InformacionMateria as $Info): ?>
                        <div class="mb-4">
                            <label class="form-label">Nombre de la Materia</label>
                            <input type="text" class="form-control" name="Nombre" required autocomplete="off" placeholder="Nombre Materia" value="<?php echo $Info['MATERIA'] ?>">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary w-100">Editar Materia</button> <br>
                <button href="../Pages/index.php" class="btn btn-secondary">Cancelar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
