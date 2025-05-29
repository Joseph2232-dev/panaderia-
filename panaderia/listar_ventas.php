<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
include 'conexion.php';

$ventas = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha_inicio = $_POST['fecha_inicio'] ?? '1970-01-01';
    $fecha_fin = $_POST['fecha_fin'] ?? '2100-01-01';
    $sql = "SELECT v.id, c.nombre AS cliente, v.fecha, v.total
            FROM ventas v
            INNER JOIN clientes c ON v.cliente_id = c.id
            WHERE v.fecha BETWEEN :fecha_inicio AND :fecha_fin";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]);
    $ventas = $stmt->fetchAll();
} else {
    $ventas = $pdo->query("SELECT v.id, c.nombre AS cliente, v.fecha, v.total
                           FROM ventas v
                           INNER JOIN clientes c ON v.cliente_id = c.id")->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <style>
        body {
            background-image: url('img/bread8.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            color: #4A4A4A;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 50px auto;
            max-width: 900px;
        }

        h1 {
            color: #D97738; 
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #D97738;
            border: none;
            transition: background-color 0.3s ease;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #F59E0B;
        }

        .btn-secondary {
            background-color: #6B4F3A;
            border: none;
            transition: background-color 0.3s ease;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .btn-secondary:hover {
            background-color: #8B5E3C;
        }

        .input-group input {
            font-size: 1.2rem;
            padding: 10px;
        }

        .input-group button {
            font-size: 1.2rem;
            padding: 10px 20px;
        }

        .table th, .table td {
            text-align: center;
            padding: 15px;
        }

        .table {
            margin-top: 30px;
            background-color: white;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #F59E0B;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mb-3">
            <a href="menu.php" class="btn btn-secondary">Volver al Menú</a>
        </div>
        <h1>Lista de Ventas</h1>
        <form method="POST" class="mb-3">
            <div class="input-group mb-3">
                <input type="date" name="fecha_inicio" class="form-control">
                <input type="date" name="fecha_fin" class="form-control">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= $venta['cliente'] ?></td>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
