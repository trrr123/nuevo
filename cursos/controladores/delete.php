
<?php

require_once('../Modelo/Cursos.php');

if($_POST){
	$ModeloCursos = new Cursos();

	$Id = $_POST['Id'];
	$ModeloCursos->delete($Id);
}else{
	header('Location: ../../index.php');
}

?>