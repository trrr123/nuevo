<?php

require_once('../Modelo/Cursos.php');

if($_POST){
	$ModeloCursos = new Cursos();

	$Id = $_POST['Id'];
	$NombreCurso = $_POST['NombreCurso'];
	$Nivel = $_POST['Nivel'];
	$Descripcion = $_POST['Descripcion'];
	$Estado = $_POST['Estado'];

	$ModeloCursos->update($Id, $NombreCurso, $Nivel, $Descripcion, $Estado);
}else{
	header('Location: ../../index.php');
}

?>