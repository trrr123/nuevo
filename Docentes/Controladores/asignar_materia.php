<?php 

require_once('../Modelo/Docentes.php');

if($_POST){
    $ModeloDocentes = new Docentes();

    $IdDocente = $_POST['IdDocente'];
    $IdMateria = $_POST['IdMateria'];
    $IdCurso = $_POST['IdCurso'];

    if($ModeloDocentes->asignarMateria($IdDocente, $IdMateria, $IdCurso)){
        header('Location: ../Pages/asignar_materias.php?Id=' . $IdDocente);
    }else{
        header('Location: ../Pages/asignar_materias.php?Id=' . $IdDocente . '&error=1');
    }
}else{
    header('Location: ../../index.php');
}

?>