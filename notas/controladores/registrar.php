<?php

require_once('../Modelo/Notas.php');
require_once('../../Usuarios/Modelo/Usuarios.php');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
	$RedirectUrl = $_POST['redirect'] ?? null; // Nueva variable para redirección personalizada

	// Validar que todos los datos estén presentes
	if (empty($IdEstudiante) || empty($IdMateria) || empty($IdCurso) || 
	    empty($IdPeriodo) || empty($IdDocente) || !isset($Valor)) {
		$_SESSION['error'] = "Todos los campos son obligatorios";
		
		// Redirección personalizada
		if ($RedirectUrl == 'ver_notas') {
			header('Location: ../../Estudiantes/Pages/ver_notas.php?Id=' . $IdEstudiante);
		} else {
			header('Location: ../Pages/registrar_notas.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
		}
		exit();
	}

	// Validar que el valor de la nota sea válido
	if (!is_numeric($Valor) || $Valor < 0 || $Valor > 100) {
		$_SESSION['error'] = "El valor de la nota debe estar entre 0 y 100";
		
		if ($RedirectUrl == 'ver_notas') {
			header('Location: ../../Estudiantes/Pages/ver_notas.php?Id=' . $IdEstudiante);
		} else {
			header('Location: ../Pages/registrar_notas.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
		}
		exit();
	}

	// VALIDACIÓN CRÍTICA: Verificar que el docente puede dar esta materia en este curso
	require_once('../../Docentes/Modelo/Docentes.php');
	$ModeloDocentes = new Docentes();
	$MateriasDocente = $ModeloDocentes->obtenerMateriasDocente($IdDocente);
	
	$puedeAsignarNota = false;
	if ($MateriasDocente) {
		foreach ($MateriasDocente as $Materia) {
			if ($Materia['ID_MATERIA'] == $IdMateria && $Materia['ID_CURSO'] == $IdCurso) {
				$puedeAsignarNota = true;
				break;
			}
		}
	}
	
	if (!$puedeAsignarNota) {
		$_SESSION['error'] = "No tienes permiso para asignar notas de esta materia en este curso. Solo puedes asignar notas en las materias y cursos que te han sido asignados.";
		
		if ($RedirectUrl == 'ver_notas') {
			header('Location: ../../Estudiantes/Pages/ver_notas.php?Id=' . $IdEstudiante);
		} else {
			header('Location: ../Pages/registrar_notas.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
		}
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
	
	// Actualizar promedio del estudiante
	if ($exito) {
		try {
			$conexion = new mysqli("localhost", "root", "", "notas");
			if (!$conexion->connect_error) {
				// Calcular nuevo promedio
				$queryPromedio = "SELECT AVG(VALOR_NOTA) as promedio FROM notas WHERE ID_ESTUDIANTE = " . intval($IdEstudiante);
				$resultPromedio = $conexion->query($queryPromedio);
				if ($resultPromedio && $row = $resultPromedio->fetch_assoc()) {
					$nuevoPromedio = round($row['promedio'], 2);
					// Actualizar promedio en tabla estudiantes
					$queryUpdate = "UPDATE estudiantes SET PROMEDIO = " . $nuevoPromedio . " WHERE ID_ESTUDIANTE = " . intval($IdEstudiante);
					$conexion->query($queryUpdate);
				}
				$conexion->close();
			}
		} catch (Exception $e) {
			// Error silencioso - no afecta el flujo principal
		}
	}
	
	// Redirección según origen
	if ($RedirectUrl == 'ver_notas') {
		header('Location: ../../Estudiantes/Pages/ver_notas.php?Id=' . $IdEstudiante);
	} else {
		header('Location: ../Pages/index.php?IdCurso=' . $IdCurso . '&IdPeriodo=' . $IdPeriodo);
	}
	exit();
} else {
	header('Location: ../../index.php');
	exit();
}

?>