<?php
include 'conexion.php';

$idFactura = $_GET['id_factura'] ?? null;

if (!$idFactura) {
    die("ID de factura no proporcionado.");
}

$stmt = $conexion->prepare("SELECT f.id_factura, f.fecha, c.nombre AS cliente, u.nombre AS usuario, f.total 
                       FROM facturas f
                       JOIN clientes c ON f.id_cliente = c.id_cliente
                       JOIN usuarios u ON f.id_usuario = u.id_usuario
                       WHERE f.id_factura = ?");
$stmt->execute([$idFactura]);
$factura = $stmt->fetch(PDO::FETCH_ASSOC); //aqui obtengo los datos de la factura.

if (!$factura) {
    die("Factura no encontrada.");
}

$stmt = $conexion->prepare("SELECT p.nombre AS producto, d.cantidad, d.precio_unitario, d.subtotal
                       FROM facturas_det d
                       JOIN productos p ON d.id_producto = p.id_producto
                       WHERE d.id_factura = ?");
$stmt->execute([$idFactura]);
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$itbis = $factura['total'] * 0.18;
$totalConITBIS = $factura['total'] + $itbis;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #<?php echo $factura['id_factura']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFD700;
            color: #333;
        }
        @page {
            size: 148mm 210mm; /* Tamaño media hoja A4 */
            margin: 10mm;
        }
        body {
            margin: 0;
            padding: 10mm;
        }
        .factura-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 0;
        }
        h1, h3 {
            text-align: center;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .btn-print {
            display: block;
            width: 40%;
            padding: 10px;
            background-color: #0078D7;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-print:hover {
            background-color: #005A9E;
        }
        .btn-link {
            display: block;
            width: 10%;
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

        /* Estilos para impresión */
        @media print {
            .btn-print {
                display: none; /* esto para ocultar el botón de impresión durante la impresión */
            }
            body {
                background-color: white;
            }
            .factura-container {
                width: 100%;
                max-width: none;
                margin: 0;
            }
            table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    
    <div class="factura-container">
        <h1>Factura #<?php echo $factura['id_factura']; ?></h1>
        <h3>Fecha: <?php echo $factura['fecha']; ?></h3>
        <p><strong>Cliente:</strong> <?php echo $factura['cliente']; ?></p>
        <p><strong>Atendido por:</strong> <?php echo $factura['usuario']; ?></p>
        
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?php echo $detalle['producto']; ?></td>
                    <td><?php echo $detalle['cantidad']; ?></td>
                    <td>$<?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                    <td>$<?php echo number_format($detalle['subtotal'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="itbis">ITBIS (18%): $<?php echo number_format($itbis, 2); ?></p>
        <p class="total">Total: $<?php echo number_format($totalConITBIS, 2); ?></p>
        <a href="javascript:window.print()" class="btn-print">Imprimir Factura</a>
    </div>

    <button class="btn-link" onclick="location.href='home.php'">Ir a inicio</button>
</body>
</html>
