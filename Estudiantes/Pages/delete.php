<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

$Id = $_GET['Id'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Eliminar Estudiante</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6 col-lg-5">
			<div class="card p-4 shadow-sm">
				<h3 class="mb-3 text-center text-danger">Eliminar Estudiante</h3>
				<form method="POST" action="../Controladores/delete.php">
					<input type="hidden" name="Id" value="<?php echo $Id ?>">

					<p class="text-center mb-4">¿Estás seguro de que deseas eliminar este estudiante?</p>

					<div class="d-flex justify-content-between">
						<a href="../Pages/index.php" class="btn btn-secondary">Cancelar</a>
						<button type="submit" class="btn btn-danger">Eliminar Estudiante</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
