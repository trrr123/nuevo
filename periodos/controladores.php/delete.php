<?php

require_once('../Modelo/Periodos.php');

if($_POST){
	$ModeloPeriodos = new Periodos();

	$Id = $_POST['Id'];
	$ModeloPeriodos->delete($Id);
}else{
	header('Location: ../../index.php');
}

?>