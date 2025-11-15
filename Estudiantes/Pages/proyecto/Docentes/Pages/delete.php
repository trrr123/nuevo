<?php  

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Docentes.php');

$ModeloUsuarios = new Usuarios();
$ModeloDocentes = new Docentes();

$ModeloUsuarios->validateSession();

$Id = $_GET['Id'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Notas</title>
</head>
<body>
	<h1>Eliminar Docente</h1>
	<form action="../Controladores/delete.php" method="POST">
		<p>¿Estas seguro de eliminar este Docente?</p>
		<input type="hidden" name="Id" value="<?php echo $Id; ?>">
		<input type="submit" name="Eliminar" value="Eliminar">
	</form>
</body>
</html>