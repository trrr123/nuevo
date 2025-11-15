<?php
// Recibir datos del formulario
$nombre     = $_POST['Nombre'];
$apellido   = $_POST['Apellido'];
$usuario    = $_POST['Usuario'];
$clave      = $_POST['Contraseña'];
$perfil     = $_POST['Perfil'];
$estado     = $_POST['Estado'];

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "notas");
if ($conn->connect_error) { 
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el usuario ya existe
$check = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$check->bind_param("s", $usuario);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "El usuario ya existe. <a href='../../registro.php'>Volver</a>";
} else {
    // Insertar nuevo usuario (guardando la contraseña en texto plano)
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, usuario, password, perfil, estado) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido, $usuario, $clave, $perfil, $estado);
    
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente. <a href='../../index.php'>Iniciar sesión</a>";
    } else {
        echo "Error al registrar: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
