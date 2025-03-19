<?php
include 'conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['clienteId']) || !isset($data['productos']) || empty($data['productos'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$clienteId = intval($data['clienteId']);
$productos = $data['productos'];

try {
    $conexion->beginTransaction();

    // para insertar factura
    $stmt = $conexion->prepare("INSERT INTO facturas (id_cliente, id_usuario, total) VALUES (?, ?, ?) RETURNING id_factura");
    $total = array_reduce($productos, fn($sum, $p) => $sum + ($p['precio'] * $p['cantidad']), 0);
    $idUsuario = 1;
    $stmt->execute([$clienteId, $idUsuario, $total]);
    $idFactura = $stmt->fetchColumn();

    // para insertar los detalles de factura
    $stmt = $conexion->prepare("INSERT INTO facturas_det (id_factura, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    foreach ($productos as $producto) {
        $stmt->execute([$idFactura, $producto['id'], $producto['cantidad'], $producto['precio']]);
    }

    $conexion->commit();
    echo json_encode(['success' => true, 'message' => 'Factura guardada con éxito']);
} catch (Exception $e) {
    $conexion->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error al guardar la factura: ' . $e->getMessage()]);
}
?>
