<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas - Login</title>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .login-box h1 {
            margin-bottom: 24px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .btn {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .btn-register {
    		display: block;
    		width: 100%;
    		padding: 12px;
   			border: none;
    		border-radius: 8px;
    		font-size: 16px;
    		cursor: pointer;
    		background-color: rgb(19, 207, 75);
    		color: white;
    		text-align: center;
    		text-decoration: none;
    		box-sizing: border-box;
		}

        .btn-register:hover {
            background-color: #5a6268;
        }

		.form-actions {
    		display: flex;
   	 		flex-direction: column;
    		gap: 1px;
    		width: 100%;
		}

    </style>
</head>
<body>
    <div class="login-box">
        <h1>Inicio de Sesión</h1>
        <form method="POST" action="Usuarios/Controladores/Login.php">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="Usuario" placeholder="Ingresa tu usuario" required autocomplete="off">

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="Contraseña" placeholder="Ingresa tu contraseña" required autocomplete="off">

            <div class="form-actions">
                <input type="submit" class="btn btn-login" value="Iniciar Sesión">
                <a href="Registro.php" class="btn btn-register">Registrarse</a>
            </div>
        </form>
    </div>
</body>
</html>
