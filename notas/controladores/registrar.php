<?php

require_once('../Modelo/Notas.php');

if($_POST){
	$ModeloNotas = new Notas();

	$IdEstudiante = $_POST['IdEstudiante'];
	$IdMateria = $_POST['IdMateria'];
	$IdCurso = $_POST['IdCurso'];
	$IdPeriodo = $_POST['IdPeriodo'];
	$IdDocente = $_POST['IdDocente'];
	$Valor = $_POST['Valor'];

	// Verificar si ya existe una nota
	$NotaExistente = $ModeloNotas->verificarNotaExistente($IdEstudiante, $IdMateria, $IdCurso, $IdPeriodo, $IdDocente);
	
	if ($NotaExistente) {
		// Actualizar nota existente
		$ModeloNotas->update($NotaExistente, $Valor);
	} else {
		// Crear nueva nota
		$ModeloNotas->add($IdEstudiante, $IdMateria, $IdCurso, $IdPeriodo, $IdDocente, $Valor);
	}
	
	header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
}else{
	header('Location: ../../index.php');
}

?>