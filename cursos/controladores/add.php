
<?php

require_once('../Modelo/Cursos.php');

if($_POST){
	$ModeloCursos = new Cursos();

	$NombreCurso = $_POST['NombreCurso'];
	$Nivel = $_POST['Nivel'];
	$Descripcion = $_POST['Descripcion'];

	$ModeloCursos->add($NombreCurso, $Nivel, $Descripcion);
}else{
	header('Location: ../../index.php');
}

?>