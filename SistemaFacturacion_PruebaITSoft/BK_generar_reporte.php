<?php
include('conexion.php');

$tipo_reporte = $_POST['tipo_reporte'];
$cliente = $_POST['cliente'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$producto = $_POST['producto'];
$vendedor = $_POST['vendedor'];

$reporte = []; // inicialice el resultado del reporte

if (!empty($fecha_inicio)) {
    $fecha_inicio = date('Y-m-d 00:00:00', strtotime($fecha_inicio));
}
if (!empty($fecha_fin)) {
    $fecha_fin = date('Y-m-d 23:59:59', strtotime($fecha_fin));
}

// Consultas para cada tipo de reporte
switch ($tipo_reporte) {
    case 'clientes':
        $sql = "SELECT id_cliente, nombre, email, telefono, direccion, ciudad FROM clientes";
        $stmt = $conexion->query($sql);
        $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 'facturas':
        // Reporte de facturas
        $sql = "SELECT f.id_factura, c.nombre AS cliente_nombre, f.fecha, f.total, u.nombre AS vendedor_nombre 
                FROM facturas f
                JOIN clientes c ON f.id_cliente = c.id_cliente
                JOIN usuarios u ON f.id_usuario = u.id_usuario
                WHERE TRUE";

        // Filtro por cliente
        if (!empty($cliente)) {
            $sql .= " AND c.id_cliente = :cliente";
        }

        // Filtro por rango de fechas
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $sql .= " AND f.fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }

        // Filtro por vendedor
        if (!empty($vendedor)) {
            $sql .= " AND u.id_usuario = :vendedor";
        }

        $stmt = $conexion->prepare($sql);

        if (!empty($cliente)) {
            $stmt->bindParam(':cliente', $cliente, PDO::PARAM_INT);
        }
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
        }
        if (!empty($vendedor)) {
            $stmt->bindParam(':vendedor', $vendedor, PDO::PARAM_INT);
        }

        $stmt->execute();
        $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 'detalles_factura':
        $sql = "SELECT f.id_factura, c.nombre AS cliente_nombre, p.nombre AS producto_nombre, fd.cantidad, fd.precio_unitario, fd.subtotal 
                FROM facturas_det fd
                JOIN facturas f ON fd.id_factura = f.id_factura
                JOIN clientes c ON f.id_cliente = c.id_cliente
                JOIN productos p ON fd.id_producto = p.id_producto
                WHERE TRUE";

        // Filtro por cliente
        if (!empty($cliente)) {
            $sql .= " AND c.id_cliente = :cliente";
        }

        // Filtro por rango de fechas
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $sql .= " AND f.fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }

        if (!empty($producto)) {
            $sql .= " AND p.id_producto = :producto";
        }

        $stmt = $conexion->prepare($sql);

        if (!empty($cliente)) {
            $stmt->bindParam(':cliente', $cliente, PDO::PARAM_INT);
        }
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
        }
        if (!empty($producto)) {
            $stmt->bindParam(':producto', $producto, PDO::PARAM_INT);
        }

        $stmt->execute();
        $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 'productos':
        $sql = "SELECT 
           nombre AS Nombre_producto, 
           categoria AS Categoria, 
           stock AS Stock, 
           precio AS Precio_producto
        FROM productos";
         $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 'productos_vendidos':
        $sql = "SELECT p.nombre AS producto_nombre, SUM(fd.cantidad) AS cantidad_vendida
                FROM facturas_det fd
                JOIN productos p ON fd.id_producto = p.id_producto
                JOIN facturas f ON fd.id_factura = f.id_factura
                WHERE TRUE";

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $sql .= " AND f.fecha BETWEEN :fecha_inicio AND :fecha_fin";
        }

        $sql .= " GROUP BY p.nombre ORDER BY cantidad_vendida DESC";

        $stmt = $conexion->prepare($sql);

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
        }

        $stmt->execute();
        $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    default:
        echo "Tipo de reporte no válido.";
        exit;
}

echo "<h3>Reporte Generado</h3>";
echo "<table border='1'>
        <tr>";


foreach ($reporte[0] as $key => $value) {
    
    $header = ($key == 'fecha') ? 'Fecha' : $key;
    echo "<th>$header</th>";
}

echo "</tr>";

foreach ($reporte as $row) {
    echo "<tr>";
    foreach ($row as $key => $value) {
        if ($key == 'fecha') {
            $value = date('Y-m-d H:i:s', strtotime($value)); 
        }
        echo "<td>$value</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>
