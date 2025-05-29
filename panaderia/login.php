<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = md5($_POST['contrasena']);

    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario AND contrasena = :contrasena";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nombre_usuario' => $nombre_usuario, 'contrasena' => $contrasena]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $_SESSION['usuario'] = $usuario['nombre_usuario'];
        header('Location: menu.php');
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Panadería Doña Lidia</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('img/fondo_panaderia.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Roboto', sans-serif;
            color: #4A4A4A;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 100px auto;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            font-family: 'Pacifico', cursive;
            color: #D97738; 
            text-align: center;
            font-size: 3rem;
            margin-bottom: 30px; 
        }

        .alert {
            font-size: 1rem;
            padding: 10px;
            text-align: center;
        }

        .alert-danger {
            background-color: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }

        .form-label {
            font-size: 1.1rem;
        }

        .form-control {
            font-size: 1.2rem;
            padding: 10px;
            margin-bottom: 15px; 
        }

        .btn-primary {
            background-color: #D97738;
            border: none;
            transition: background-color 0.3s ease;
            color: white;
            padding: 10px 20px;
            font-size: 1.2rem;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #F59E0B;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
            height: auto;
        }
        

    </style>
</head>
<body>
  
  

    <div class="container">
        <h1>Panadería Doña Lidia</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" id="nombre_usuario" placeholder="Ingrese nombre de usuario" name="nombre_usuario" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="contrasena" placeholder="Ingrese contraseña" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</body>
</html>
