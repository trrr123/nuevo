<?php

require_once('../Modelo/Periodos.php');

if($_POST){
	$ModeloPeriodos = new Periodos();

	$NombrePeriodo = $_POST['NombrePeriodo'];
	$FechaInicio = $_POST['FechaInicio'];
	$FechaFin = $_POST['FechaFin'];
	$Descripcion = $_POST['Descripcion'];

	$ModeloPeriodos->add($NombrePeriodo, $FechaInicio, $FechaFin, $Descripcion);
}else{
	header('Location: ../../index.php');
}

?>