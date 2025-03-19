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
            min-height: 50vh;
        }

        header {
            background-color: #0078D7;
            color: white;
            padding: 20px;
            font-size: 24px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header-left {
            position: absolute;
            left: 20px;
        }
        .header-left button {
            background-color: white;
            border: none;
            padding: 10px 15px;
            margin-right: 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .header-left button:hover {
            background-color: #e0e0e0;
        }
        .menu-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            justify-content: center;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .menu-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            justify-content: center;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .menu-container a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 150px;
            background-color: #0078D7;
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            transition: 0.3s;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .menu-container a:hover {
            background-color: #005A9E;
            transform: scale(1.1);
        }
        footer {
            background-color: #0078D7;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <button onclick="location.href='configuracion.php'">⚙️ Configuración</button>
            <button onclick="location.href='logout.php'">Logout</button>
        </div>
        <h1>Sistema de Facturación</h1>
    </header>

    <main class="menu-container">
        <a href="registro_clientes.php">Registro de Clientes</a>
        <a href="registro_productos.php">Registro de Productos</a>
        <a href="facturacion.php">Facturación</a>
        <a href="reporte_clientes.php">Reportería</a>
        <a href="reporte_facturas.php"></a>
        <a href="registro_clientes.php"></a>
        <a href="registro_productos.php"></a>
        <a href="facturacion.php">Historial de Facturación</a>
        <a href="reporte_clientes.php">Usuarios</a>
        <a href="reporte_facturas.php">Proveedores</a>
    </main>

    <footer>
        <p>&copy; 2025 Sistema de Facturación. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

