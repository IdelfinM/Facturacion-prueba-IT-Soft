<?php
require 'conexion.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación - Página Principal</title>
    <style>
        body {
            background-color: #FFD700;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #FFB300;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
            font-size: 2.5em;
        }
        main {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            max-width: 1400px;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #FF8C00;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #FF8C00;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            margin: 5px 0;
        }
        button:hover {
            background-color: #FF7F00; /* Color de fondo al pasar el mouse */
        }
        .message-box {
            background-color: #e7f3fe; /* Color de fondo para mensajes */
            color: #31708f; /* Color del texto para mensajes */
            border: 1px solid #bce8f1;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .form-container {
            flex: 1;
            max-width: 350px; /* Ancho fijo para el formulario */
            margin-left: 20px;
        }
        .table-container {
            flex: 2; /* La tabla ocupa más espacio */
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 600px) {
            body {
                flex-direction: column;
            }
            main {
                flex-direction: column; /* Cambiar a columna en pantallas pequeñas */
            }
            .form-container {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
        footer {
            text-align: center;
            padding: 5px;
            background-color: #FFB300; /* Mismo color que el encabezado */
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Sistema de Facturación</h1>
    </header>
    <main>
        <div class="table-container">
            <h3>Listado de Productos</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conexion.php';

                    $sql = "SELECT * FROM productos";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($productos as $producto) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($producto['id_producto']) . "</td>";
                        echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($producto['descripcion']) . "</td>";
                        echo "<td>" . htmlspecialchars($producto['precio']) . "</td>";
                        echo "<td>" . htmlspecialchars($producto['stock']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="form-container">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message-box">
                    <p><?php echo $_SESSION['message']; ?></p>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <form action="BK_insertar_producto.php" method="POST">
                <h3>Formulario de creación de productos</h3>
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" min="0" required>

                <button type="submit">Agregar Producto</button>
                <a href="home.php"><button type="button" class="btn-inicio">Ir a inicio</button></a>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Sistema de Facturación. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

