<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock)
            VALUES (:nombre, :descripcion, :precio, :stock)";
    
    try {
        $stmt = $conexion->prepare($sql);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);

        $stmt->execute();

        $_SESSION['message'] = 'Producto agregado exitosamente.';

        header('Location: registro_productos.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error al agregar producto: ' . $e->getMessage();
        header('Location: registro_productos.php');
        exit();
    }
}
?>