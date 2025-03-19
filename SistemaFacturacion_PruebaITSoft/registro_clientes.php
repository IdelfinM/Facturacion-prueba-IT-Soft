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
            max-width: 1200px;
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
        .table-container {
            flex: 2;
            overflow-x: auto;
        }
        table {
            width: 150%;
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
                flex-direction: column;
            }
            .form-container {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
        footer {
            text-align: center;
            padding: 5px;
            background-color: #FFB300;
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
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Ciudad</th>
                        <th>Direccion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conexion.php';

                    $sql = "SELECT * FROM clientes";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($clientes as $cliente) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($cliente['id_cliente']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['telefono']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['ciudad']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['direccion']) . "</td>";
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
            <form action="BK_registro_clientes.php" method="POST">

                <div>
                    <h3>Formulario de creacion de clientes.</h3>
                </div>
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono">
                </div>

                <div>
                    <?php
                    $query = "SELECT unnest(enum_range(NULL::ciudad_enum)) AS ciudad";
                    $resultado = $conexion->query($query);

                    echo '<label for="ciudad">Ciudad:</label>';
                    echo '<select id="ciudad" name="ciudad" required>';
                    echo '<option value="" selected disabled>Seleccione una ciudad</option>';
                    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . htmlspecialchars($fila['ciudad']) . '">' . htmlspecialchars($fila['ciudad']) . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>

                <div>
                    <label for="direccion">Dirección:</label>
                    <textarea id="direccion" name="direccion" required></textarea>
                </div>

                <div>
                    <button type="submit" class="btn-registrar">Registrar Cliente</button>
                </div>
                <div>
                    <a href="home.php"><button type="button" class="btn-inicio">Ir a inicio</button></a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Sistema de Facturación. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

