<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../../Metodos.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

$ModeloMetodos = new Metodos();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h2 class="mb-4 text-center">Registrar Estudiante</h2>

                <form method="POST" action="../Controladores/add.php" class="card p-4 shadow-sm">
                    <div class="mb-3">
                        <label for="Nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="Nombre" id="Nombre" required autocomplete="off" placeholder="Nombre">
                    </div>

                    <div class="mb-3">
                        <label for="Apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="Apellido" id="Apellido" required autocomplete="off" placeholder="Apellido">
                    </div>

                    <div class="mb-3">
                        <label for="Documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" name="Documento" id="Documento" required autocomplete="off" placeholder="Documento">
                    </div>

                    <div class="mb-3">
                        <label for="Correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="Correo" id="Correo" required autocomplete="off" placeholder="Correo">
                    </div>

                    <div class="mb-3">
                        <label for="Materia" class="form-label">Materia</label>
                        <select name="Materia" id="Materia" class="form-select" required>
                            <option value="">Seleccione</option>
                            <?php 
                            $Materias = $ModeloMetodos->getMaterias();
                            if ($Materias != null){
                                foreach ($Materias as $Materia){
                            ?>
                            <option value="<?php echo $Materia['MATERIA']; ?>"><?php echo $Materia['MATERIA']; ?></option>
                            <?php
                                }
                            }
                            ?>	
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Docente" class="form-label">Docente</label>
                        <select name="Docente" id="Docente" class="form-select" required>
                            <option value="">Seleccione</option>
                            <?php 
                            $Docentes = $ModeloMetodos->getDocentes();
                            if ($Docentes != null){
                                foreach ($Docentes as $Docente){
                            ?>
                            <option value="<?php echo $Docente['NOMBRE'] . ' ' . $Docente['APELLIDO']; ?>">
                                <?php echo $Docente['NOMBRE'] . ' ' . $Docente['APELLIDO']; ?>
                            </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="Promedio" class="form-label">Promedio</label>
                        <input type="number" class="form-control" name="Promedio" id="Promedio" required autocomplete="off" placeholder="Promedio" step="0.01" min="0" max="100">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">Registrar Estudiante</button>
                        <a href="index.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>