<?php

require_once('../Modelo/Notas.php');

if($_POST){
	$ModeloNotas = new Notas();

	$IdNota = $_POST['IdNota'];
	$IdCurso = $_POST['IdCurso'] ?? null;
	$IdPeriodo = $_POST['IdPeriodo'] ?? null;
	$IdEstudiante = $_POST['IdEstudiante'] ?? null; // Nuevo parámetro

	session_start(); // Asegurar que la sesión esté iniciada
	
	if($ModeloNotas->delete($IdNota)){
		// Si viene de la página de ver notas de un estudiante
		if ($IdEstudiante) {
			$_SESSION['mensaje'] = "Nota eliminada exitosamente";
			header('Location: ../../Estudiantes/Pages/ver_notas.php?Id=' . $IdEstudiante);
		} 
		// Si viene de la página de notas general
		elseif ($IdCurso && $IdPeriodo) {
			header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
		}
		// Fallback
		else {
			header('Location: ../Pages/index.php');
		}
	} else {
		$_SESSION['error'] = "Error al eliminar la nota";
		if ($IdEstudiante) {
			header('Location: ../../Estudiantes/Pages/ver_notas.php?Id=' . $IdEstudiante);
		} elseif ($IdCurso && $IdPeriodo) {
			header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo . '&error=1');
		} else {
			header('Location: ../Pages/index.php');
		}
	}
}else{
	header('Location: ../../index.php');
}

?>