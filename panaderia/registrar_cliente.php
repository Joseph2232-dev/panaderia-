<?php
include 'conexion.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];

    $sql = "INSERT INTO clientes (nombre, contacto) VALUES (:nombre, :contacto)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nombre' => $nombre, 'contacto' => $contacto]);

    echo "<div class='alert alert-success text-center'>Cliente registrado exitosamente.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Registrar Cliente</title>
    <style>
        body {
            background-image: url('img/bread4.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            color: #4A4A4A;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        h1 {
            color: #D97738;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #D97738;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #F59E0B;
        }

        .btn-secondary {
            background-color: #6B4F3A;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #8B5E3C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mb-3 text-end">
            <a href="menu.php" class="btn btn-secondary">Volver al Menú</a>
        </div>

        <h1>Registrar Cliente</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del cliente</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto</label>
                <input type="text" class="form-control" id="contacto" name="contacto">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</body>
</html>

