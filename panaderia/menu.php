<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <title>Menú Principal</title>
    <style>
 
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FFF9F0;
            color: #5D3F00;
            margin: 0;
            padding: 0;
            background-image: url('img/bread2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        h1 {
            font-family: 'Pacifico', cursive; 
            color: #D97738; 
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        hr {
            border: 1px solid #D97738; 
            width: 50%;
            margin: 20px auto;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            border: 2px solid #D97738; 
        }

        .list-group-item {
            background-color: #F4E1C1;
            border: none;
            padding: 15px;
            font-size: 1.1rem;
            text-align: left;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .list-group-item a {
            color: #5D3F00; 
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .list-group-item a:hover {
            background-color: #D97738;
            color: white;
        }

        .list-group-item a:active {
            background-color: #F59E0B; 
        }

        .list-group-item a {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .list-group-item a:hover {
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-logout {
            background-color: #F59E0B; 
            color: white;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #D97738;
            color: white;
        }

        footer {
            background-color: #D97738;
            color: white;
            padding: 0px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .highlight {
            color: #D97738;
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, <span class="highlight"><?= htmlspecialchars($_SESSION['usuario']) ?></span></h1>
        <h1><hr>PANADERÍA  DOÑA LIDIA</h1>
        <ul class="list-group mt-3">
            <li class="list-group-item"><a href="registrar_producto.php">Registrar Producto</a></li>
            <li class="list-group-item"><a href="registrar_cliente.php">Registrar Cliente</a></li>
            <li class="list-group-item"><a href="registrar_venta.php">Registrar Venta</a></li>
            <li class="list-group-item"><a href="listar_productos.php">Lista de Productos</a></li>
            <li class="list-group-item"><a href="listar_clientes.php">Lista de Clientes</a></li>
            <li class="list-group-item"><a href="listar_ventas.php">Lista de Ventas</a></li>
            <li class="list-group-item"><a class="btn-logout" href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </div>

    <footer>
        <p>&copy; 2024 Panadería Doña Lidia - Todos los derechos reservados</p>
    </footer>
</body>
</html>
