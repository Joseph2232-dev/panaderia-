<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, stock = :stock WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nombre' => $nombre, 'precio' => $precio, 'stock' => $stock, 'id' => $id]);

    header('Location: listar_productos.php');
    exit();
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $producto = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Editar Producto</title>
</head>
<body>
<div class="container mt-5">
    <div class="mb-3">
    <a href="listar_productos.php" class="btn btn-secondary">Volver a Lista de Productos</a>
</div>
    <div class="container mt-5">
        <form method="POST">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?= $producto['stock'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
</html>
