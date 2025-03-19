<?php
include('conexion.php');
?>
<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
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
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #FF8C00;
        }
        main {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
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
        select,
        input[type="date"] {
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
            margin-top: 10px;
        }
        button:hover {
            background-color: #FF7F00;
        }
        .message-box {
            background-color: #e7f3fe;
            color: #31708f;
            border: 1px solid #bce8f1;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .form-container {
            flex: 1;
            max-width: 350px;
            margin-left: 20px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #FFB300;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>Generar Reporte</h1>
</header>

<main>
    <div class="form-container">
        <h2>Formulario de Reporte</h2>
        <form action="BK_generar_reporte.php" method="post">
            <!-- Selección del tipo de reporte -->
            <label for="tipo_reporte">Tipo de Reporte:</label>
            <select name="tipo_reporte" id="tipo_reporte" required>
                <option value="clientes">Reporte de Clientes</option>
                <option value="facturas">Reporte de Facturas</option>
                <option value="detalles_factura">Reporte Detallado de Facturas</option>
                <option value="productos">Reporte de Productos</option>
                <option value="productos_vendidos">Reporte de Productos Más Vendidos</option>
            </select>

            <label for="cliente">Cliente:</label>
            <select name="cliente" id="cliente">
            <option value="">Selecciona Cliente</option>
                <?php
                
                $sql = "SELECT id_cliente, nombre FROM clientes";
                $stmt = $conexion->query($sql);

                if ($stmt) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id_cliente'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay clientes disponibles</option>";
                }
                ?>
            </select>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio">

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin">

            <label for="producto">Producto:</label>
            <select name="producto" id="producto">
            <option value="">Selecciona Cliente</option>
                <?php
                    
                    $sql = "SELECT id_producto, nombre FROM productos";
                    $stmt = $conexion->query($sql);

                    if ($stmt) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['id_producto'] . "'>" . $row['nombre'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay productos disponibles</option>";
                    }
                ?>
            </select>

            <label for="vendedor">Vendedor:</label>
            <select name="vendedor" id="vendedor">
                <option value="">Selecciona Vendedor</option>
                <?php
                    
                    $sql = "SELECT id_usuario, nombre FROM usuarios";
                    $stmt = $conexion->query($sql);

                    if ($stmt) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['id_usuario'] . "'>" . $row['nombre'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay usuarios disponibles</option>";
                    }
                ?>
            </select>

            <button type="submit">Generar Reporte</button>
            
        </form>
    </div>
    <!-- <div class="table-container">
        
    </div> -->
</main>
<button class="btn-link" onclick="location.href='home.php'">Ir a inicio</button>
<footer>
    <p>&copy; 2025 Reportes Generados</p>
</footer>

</body>
</html>
