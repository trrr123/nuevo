<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

$Id = $_GET['Id'];


?>

<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Notas</title>
</head>
<body>
	<h1>Eliminar Estudiante</h1>
	<form method="POST" action="../Controladores/delete.php">
		<input type="hidden" name="Id" value="<?php echo $Id ?>">
		<p>¿Estas seguro de eliminar este estudiante?</p>
		<input type="submit" name="Eliminar Estudiante">
	</form>

</body>
</html>