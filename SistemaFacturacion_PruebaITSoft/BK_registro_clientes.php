<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO clientes (nombre, email, telefono, ciudad, direccion)
            VALUES (:nombre, :email, :telefono, :ciudad, :direccion)";
    
    try {
        $stmt = $conexion->prepare($sql);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':direccion', $direccion);

        $stmt->execute();

        $_SESSION['message'] = 'Cliente registrado exitosamente.';

        header('Location: registro_clientes.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error al registrar cliente: ' . $e->getMessage();
        header('Location: registro_clientes.php');
        exit();
    }
}
?>
