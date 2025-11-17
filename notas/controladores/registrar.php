<?php

require_once('../Modelo/Notas.php');
require_once('../../Usuarios/Modelo/Usuarios.php');

// Validar sesión
$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

if($_POST){
	$ModeloNotas = new Notas();

	$IdEstudiante = $_POST['IdEstudiante'];
	$IdMateria = $_POST['IdMateria'];
	$IdCurso = $_POST['IdCurso'];
	$IdPeriodo = $_POST['IdPeriodo'];
	$IdDocente = $_POST['IdDocente'];
	$Valor = $_POST['Valor'];

	// Validar que todos los datos estén presentes
	if (empty($IdEstudiante) || empty($IdMateria) || empty($IdCurso) || 
	    empty($IdPeriodo) || empty($IdDocente) || !isset($Valor)) {
		$_SESSION['error'] = "Todos los campos son obligatorios";
		header('Location: ../Pages/registrar_notas.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
		exit();
	}

	// Validar que el valor de la nota sea válido
	if (!is_numeric($Valor) || $Valor < 0 || $Valor > 100) {
		$_SESSION['error'] = "El valor de la nota debe estar entre 0 y 100";
		header('Location: ../Pages/registrar_notas.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
		exit();
	}

	// Verificar si ya existe una nota
	$NotaExistente = $ModeloNotas->verificarNotaExistente($IdEstudiante, $IdMateria, $IdCurso, $IdPeriodo, $IdDocente);
	
	$exito = false;
	if ($NotaExistente) {
		// Actualizar nota existente
		$exito = $ModeloNotas->update($NotaExistente, $Valor);
		$_SESSION['mensaje'] = $exito ? "Nota actualizada exitosamente" : "Error al actualizar la nota";
	} else {
		// Crear nueva nota
		$exito = $ModeloNotas->add($IdEstudiante, $IdMateria, $IdCurso, $IdPeriodo, $IdDocente, $Valor);
		$_SESSION['mensaje'] = $exito ? "Nota registrada exitosamente" : "Error al registrar la nota";
	}
	
	if (!$exito) {
		$_SESSION['error'] = "No se pudo guardar la nota. Verifica los datos e intenta nuevamente.";
	}
	
	header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
	exit();
} else {
	header('Location: ../../index.php');
	exit();
}

?>