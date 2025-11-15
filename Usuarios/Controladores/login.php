<?php 
session_start(); // Necesario para usar $_SESSION

require_once('../Modelo/Usuarios.php');

if($_POST){
	$Usuario = $_POST['Usuario'];
	$Password = $_POST['Contraseña'];

	$Modelo = new Usuarios();
	if ($Modelo->login($Usuario, $Password)){
		header('Location: ../../Estudiantes/Pages/index.php');
	} else {
		$_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
		header('Location: ../../index.php');
	}
} else {
	header('Location: ../../index.php');
}
?>
