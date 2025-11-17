<?php

require_once('../Modelo/Periodos.php');

if($_POST){
	$ModeloPeriodos = new Periodos();

	$Id = $_POST['Id'];
	$NombrePeriodo = $_POST['NombrePeriodo'];
	$FechaInicio = $_POST['FechaInicio'];
	$FechaFin = $_POST['FechaFin'];
	$Descripcion = $_POST['Descripcion'];
	$Estado = $_POST['Estado'];

	$ModeloPeriodos->update($Id, $NombrePeriodo, $FechaInicio, $FechaFin, $Descripcion, $Estado);
}else{
	header('Location: ../../index.php');
}

?>