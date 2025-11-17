<?php

require_once('../../Usuarios/Modelo/Usuarios.php');

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSessionAdministrador();

if($_POST){
    $IdEstudiante = $_POST['IdEstudiante'];
    $IdCurso = $_POST['IdCurso'];

    // Verificar si ya está asignado
    $conexion = new mysqli("localhost", "root", "", "notas");
    if ($conexion->connect_error) die("Error: " . $conexion->connect_error);

    $queryVerificar = "SELECT * FROM estudiante_cursos 
                       WHERE ID_ESTUDIANTE = " . intval($IdEstudiante) . " 
                       AND ID_CURSO = " . intval($IdCurso) . " 
                       AND ESTADO = 'Activo'";
    $resultVerificar = $conexion->query($queryVerificar);

    if ($resultVerificar->num_rows > 0) {
        // Ya existe, redirigir con error
        header('Location: ../Pages/asignar_cursos.php?Id=' . $IdEstudiante . '&error=1');
    } else {
        // Insertar nueva asignación
        $query = "INSERT INTO estudiante_cursos (ID_ESTUDIANTE, ID_CURSO, FECHA_ASIGNACION, ESTADO) 
                  VALUES (" . intval($IdEstudiante) . ", " . intval($IdCurso) . ", CURDATE(), 'Activo')";
        
        if ($conexion->query($query)) {
            header('Location: ../Pages/asignar_cursos.php?Id=' . $IdEstudiante);
        } else {
            header('Location: ../Pages/asignar_cursos.php?Id=' . $IdEstudiante . '&error=1');
        }
    }

    $conexion->close();
}else{
    header('Location: ../../index.php');
}

?>