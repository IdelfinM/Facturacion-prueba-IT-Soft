<?php
session_start(); 
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Convertir la contraseña ingresada a SHA-256 en PHP
    $password_hash = hash('sha256', $password);

    try {
        $query = "SELECT id_usuario, nombre, clave, rol FROM usuarios WHERE nombre = :usuario";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Para verificar si el usuario existe y la contraseña es correcta
        if ($user && $password_hash === $user['clave']) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];

            header("Location: home.php");
            exit();
        } else {
            // Si falla, regresar al formulario con un mensaje de error
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
}
?>

