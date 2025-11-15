<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Registro de Usuario</h2>
    <form method="POST" action="Usuarios/Controladores/Registrar.php">
        <label>Nombre</label>
        <input type="text" name="Nombre" required>

        <label>Apellido</label>
        <input type="text" name="Apellido" required>

        <label>Usuario</label>
        <input type="text" name="Usuario" required>

        <label>Contraseña</label>
        <input type="password" name="Contraseña" required>

        <label>Perfil</label>
        <select name="Perfil" required>
            <option value="">Seleccione</option>
            <option value="administrador">Administrador</option>
            <option value="docente">Docente</option>
            <option value="estudiante">Estudiante</option>
        </select>

        <label>Estado</label>
        <select name="Estado" required>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>

        <button type="submit" class="btn-primary">Registrarse</button>
        <a class="link" href="index.php">¿Ya tienes cuenta? Inicia sesión</a>
    </form>
</div>

</body>
</html>
