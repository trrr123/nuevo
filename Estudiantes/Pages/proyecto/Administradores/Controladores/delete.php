<?php 

require_once('../../Usuarios/Modelo/Usuarios.php');
require_once('../Modelo/Administradores.php'); // Asegúrate de que esta ruta sea correcta

$ModeloUsuarios = new Usuarios();
$ModeloUsuarios->validateSession();

if ($_POST){
    $ModeloAdministradores = new Administradores();

    $Id = $_POST['Id'];
    $ModeloAdministradores->delete($Id);
} else {
    header('Location: ../../index.php');
}
