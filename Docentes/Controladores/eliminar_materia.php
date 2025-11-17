<?php

require_once('../Modelo/Docentes.php');
require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSessionAdministrador();

if($_POST){
	$ModeloDocentes = new Docentes();

	$Id = $_POST['Id'];
	$IdDocente = $_POST['IdDocente'];

	if($ModeloDocentes->eliminarMateriaDocente($Id)){
		header('Location: ../Pages/asignar_materias.php?Id=' . $IdDocente);
	}else{
		header('Location: ../Pages/asignar_materias.php?Id=' . $IdDocente . '&error=1');
	}
}else{
	header('Location: ../../index.php');
}

?>