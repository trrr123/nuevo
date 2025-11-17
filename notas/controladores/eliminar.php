<?php

require_once('../Modelo/Notas.php');

if($_POST){
	$ModeloNotas = new Notas();

	$IdNota = $_POST['IdNota'];
	$IdCurso = $_POST['IdCurso'];
	$IdPeriodo = $_POST['IdPeriodo'];

	if($ModeloNotas->delete($IdNota)){
		header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
	}else{
		header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo . '&error=1');
	}
}else{
	header('Location: ../../index.php');
}

?>