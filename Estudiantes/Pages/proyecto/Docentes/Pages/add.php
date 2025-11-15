<?php  

require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Notas</title>
</head>
<body>
	<h1>Registrar Docentes</h1>
	<form action="../Controladores/add.php" method="POST">
		Nombre <br>
		<input type="text" name="Nombre" required="" autocomplete="off" placeholder="Nombre"> <br><br>
		Apellido <br>
		<input type="text" name="Apellido" required="" autocomplete="off" placeholder="Apellido"> <br><br>
		Usuario <br>
		<input type="text" name="Usuario" required="" autocomplete="off" placeholder="Usuario"> <br><br>
		Password <br>
		<input type="password" name="Password" required="" autocomplete="off" placeholder="Password"> <br><br>
		<input type="submit" name="Registrar" value="Registrar">
	</form>
</body>
</html>