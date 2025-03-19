<?php
$host = "localhost";
$port = "5432";
$dbname = "DB_tienda";
$user = "postgres";
$password = "4885";

try {
    // he conectar a PostgreSQL con PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conexion = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
