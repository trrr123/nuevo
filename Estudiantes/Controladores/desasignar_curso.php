<?php

require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSessionAdministrador();

if($_POST){
    $Id = $_POST['Id'];
    $IdEstudiante = $_POST['IdEstudiante'];

    $conexion = new mysqli("localhost", "root", "", "notas");
    if ($conexion->connect_error) die("Error: " . $conexion->connect_error);

    // Cambiar estado a Inactivo en lugar de eliminar (mejor para auditoría)
    $query = "UPDATE estudiante_cursos SET ESTADO = 'Inactivo' WHERE ID = " . intval($Id);
    
    if ($conexion->query($query)) {
        header('Location: ../Pages/asignar_cursos.php?Id=' . $IdEstudiante);
    } else {
        header('Location: ../Pages/asignar_cursos.php?Id=' . $IdEstudiante . '&error=1');
    }

    $conexion->close();
}else{
    header('Location: ../../index.php');
}

?>