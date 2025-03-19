<?php
include 'conexion.php';

$clientes = $conexion->query("SELECT id_cliente, nombre FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
$productos = $conexion->query("SELECT id_producto, nombre, precio FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Factura</title>
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
            background-color: #0078D7;
            color: white;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }
        .container {
            max-width: 100%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        select, input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #0078D7;
            color: white;
        }
        button {
            background-color: #0078D7;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #005A9E;
        }
        .btn-link {
            display: block;
            width: 30%;
            padding: 10px;
            background-color: #0078D7;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-link:hover {
            background-color: #005A9E;
        }
        .input-cantidad {
        width: 50px;
    }
    </style>
</head>
<body>
    <header>Crear Factura</header>
    <div class="container">
        <h3>Facturar:</h3>
        <label for="cliente">Cliente:</label>
        <select id="cliente">
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="producto">Producto:</label>
        <select id="producto">
            <option value="">Seleccione un producto</option>
            <?php foreach ($productos as $producto): ?>
                <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['precio']; ?>">
                    <?php echo $producto['nombre'] . " - $" . $producto['precio']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button onclick="agregarProducto()">Agregar Producto</button>
        
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="detalle"></tbody>
        </table>

        <h3>Total: $<span id="total">0</span></h3>

        <button onclick="guardarFactura()">Guardar Factura</button> <br><br>

        <label for="factura">Impprimir factura:</label>

        <select id="factura">
            <option value="">Seleccione una factura</option>
            <?php
            $facturas = $conexion->query("SELECT id_factura, fecha FROM facturas ORDER BY id_factura DESC")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($facturas as $factura):
            ?>
                <option value="<?php echo $factura['id_factura']; ?>">#<?php echo $factura['id_factura']; ?> - <?php echo $factura['fecha']; ?></option>
            <?php endforeach; ?>
        </select>
        <button onclick="imprimirFactura()">Imprimir Factura</button>
        <button class="btn-link" onclick="location.href='home.php'">Ir a inicio</button>
    </div>

    <script>
        let productosSeleccionados = [];
        function agregarProducto() {
            let select = document.getElementById("producto");
            let id = select.value;
            let nombre = select.options[select.selectedIndex].text;
            let precio = parseFloat(select.options[select.selectedIndex].getAttribute("data-precio"));
            if (id) {
                productosSeleccionados.push({ id, nombre, precio, cantidad: 1 });
                actualizarTabla();
            }
        }
        function actualizarTabla() {
            let detalle = document.getElementById("detalle");
            detalle.innerHTML = "";
            let total = 0;
            productosSeleccionados.forEach((p, index) => {
                total += p.precio * p.cantidad;
                detalle.innerHTML += `
                    <tr>
                        <td>${p.nombre}</td>
                        <td><input class="input-cantidad" type="number" value="${p.cantidad}" min="1" onchange="actualizarCantidad(${index}, this.value)"></td>
                        <td>$${p.precio}</td>
                        <td>$${p.precio * p.cantidad}</td>
                    </tr>`;
            });
            document.getElementById("total").innerText = total;
        }
        function actualizarCantidad(index, cantidad) {
            productosSeleccionados[index].cantidad = parseInt(cantidad);
            actualizarTabla();
        }
        function guardarFactura() {
            let clienteId = document.getElementById("cliente").value;
            if (!clienteId || productosSeleccionados.length === 0) {
                alert("Seleccione un cliente y agregue al menos un producto.");
                return;
            }
            fetch("BK_guardar_fact.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    clienteId,
                    productos: productosSeleccionados
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) location.reload();
            })
            .catch(error => console.error("Error:", error));
        }
        function imprimirFactura() {
            let facturaId = document.getElementById("factura").value;
            if (!facturaId) {
                alert("Seleccione una factura para imprimir.");
                return;
            }
            window.location.href = `imprimir_fact.php?id_factura=${facturaId}`;
        }
    </script>
</body>
</html>
