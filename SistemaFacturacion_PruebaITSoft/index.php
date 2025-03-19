<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Facturación</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error) echo "<p style='color: red;'>$error</p>"; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>

