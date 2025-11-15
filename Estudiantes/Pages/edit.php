<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Estudiantes.php');
require_once('../../Metodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

$Modelo = new Estudiantes();
$Id = $_GET['Id'];
$InformacionEstudiante = $Modelo->getById($Id);

$ModeloMetodos = new Metodos();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <h2 class="mb-4 text-center">Editar Estudiante</h2>

            <form method="POST" action="../Controladores/edit.php" class="card p-4 shadow-sm">
                <input type="hidden" name="Id" value="<?php echo $Id ?>">

                <?php if ($InformacionEstudiante != null): ?>
                    <?php foreach ($InformacionEstudiante as $Info): ?>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="Nombre" required autocomplete="off" value="<?php echo $Info['NOMBRE']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellido</label>
                            <input type="text" class="form-control" name="Apellido" required autocomplete="off" value="<?php echo $Info['APELLIDO']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Documento</label>
                            <input type="text" class="form-control" name="Documento" required autocomplete="off" value="<?php echo $Info['DOCUMENTO']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" class="form-control" name="Correo" required autocomplete="off" value="<?php echo $Info['CORREO']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Materia</label>
                            <select name="Materia" class="form-select" required>
                                <option value="<?php echo $Info['MATERIA'] ?>"><?php echo $Info['MATERIA'] ?></option>
                                <?php 
                                $Materias = $ModeloMetodos->getMaterias();
                                if ($Materias != null):
                                    foreach($Materias as $Materia): ?>
                                        <option value="<?php echo $Materia['MATERIA']; ?>"><?php echo $Materia['MATERIA']; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Docente</label>
                            <select name="Docente" class="form-select" required>
                                <option value="<?php echo $Info['DOCENTE'] ?>"><?php echo $Info['DOCENTE'] ?></option>
                                <?php 
                                $Docentes = $ModeloMetodos->getDocentes();
                                if ($Docentes != null):
                                    foreach($Docentes as $Docente): 
                                        $nombreCompleto = $Docente['NOMBRE'] . ' ' . $Docente['APELLIDO'];
                                ?>
                                    <option value="<?php echo $nombreCompleto ?>"><?php echo $nombreCompleto ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Promedio</label>
                            <input type="number" class="form-control" name="Promedio" required autocomplete="off" value="<?php echo $Info['PROMEDIO']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Editar Estudiante</button> <br>
                        <button href="../Pages/index.php" class="btn btn-secondary">Cancelar</button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>
