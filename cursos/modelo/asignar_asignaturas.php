<?php

require_once('../Modelo/Cursos.php');

if($_POST){
	$ModeloCursos = new Cursos();

	$IdCurso = $_POST['IdCurso'];
	$IdMateria = $_POST['IdMateria'];

	if($ModeloCursos->asignarMateria($IdCurso, $IdMateria)){
		header('Location: ../Pages/asignar_asignaturas.php?Id=' . $IdCurso);
	}else{
		header('Location: ../Pages/asignar_asignaturas.php?Id=' . $IdCurso . '&error=1');
	}
}else{
	header('Location: ../../index.php');
}

?>