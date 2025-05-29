<?php
// Conexión a la base de datos (ajusta según tu configuración)
$host = 'localhost';
$dbname = 'panaderia';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Registrar la venta al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $productos = $_POST['productos'];
    $cantidades = $_POST['cantidades'];

    // Calcular el total y registrar la venta
    $total = 0;
    foreach ($productos as $index => $producto_id) {
        $sql = "SELECT precio FROM productos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $producto_id]);
        $precio = $stmt->fetchColumn();

        $cantidad = $cantidades[$index];
        $subtotal = $precio * $cantidad;
        $total += $subtotal;
    }

    $sql = "INSERT INTO ventas (cliente_id, total) VALUES (:cliente_id, :total)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cliente_id' => $cliente_id, 'total' => $total]);
    $venta_id = $pdo->lastInsertId();

    // Registrar los detalles de la venta
    foreach ($productos as $index => $producto_id) {
        $cantidad = $cantidades[$index];
        $subtotal = $precio * $cantidad;

        $sql = "INSERT INTO detalles_ventas (venta_id, producto_id, cantidad, subtotal) 
                VALUES (:venta_id, :producto_id, :cantidad, :subtotal)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'venta_id' => $venta_id,
            'producto_id' => $producto_id,
            'cantidad' => $cantidad,
            'subtotal' => $subtotal
        ]);
    }

    echo "Venta registrada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/bread5.jpg');
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
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 50px auto;
            max-width: 600px;
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

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #D97738;
            border-radius: 5px;
            font-size: 1rem;
        }

        input:focus {
            outline: none;
            border-color: #F59E0B;
            box-shadow: 0 0 5px #F59E0B;
        }
    </style>
    <title>Registrar Venta</title>
</head>
<body>
    <div class="container mt-5">
    <div class="mb-3">
            <a href="menu.php" class="btn btn-secondary">Volver al Menú</a>
        </div>
        <h1>Registrar Venta</h1>
        <form method="POST" id="ventaForm">
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-select" id="cliente_id" name="cliente_id" required>
                    <?php
                    $clientes = $pdo->query("SELECT id, nombre FROM clientes")->fetchAll();
                    foreach ($clientes as $cliente) {
                        echo "<option value='{$cliente['id']}'>{$cliente['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div id="productos">
                <div class="mb-3 producto-row">
                    <label class="form-label">Producto</label>
                    <select class="form-select" name="productos[]">
                        <?php
                        $productos = $pdo->query("SELECT id, nombre, precio FROM productos")->fetchAll();
                        foreach ($productos as $producto) {
                            echo "<option value='{$producto['id']}' data-precio='{$producto['precio']}'>{$producto['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" class="form-control mt-2" name="cantidades[]" placeholder="Cantidad" required>
                    <button type="button" class="btn btn-danger btn-sm mt-2 eliminar-producto" onclick="eliminarProducto(this)">Eliminar</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="agregarProducto()">Agregar otro producto</button>
            <button type="button" class="btn btn-success mb-3" id="calcularTotal">Mostrar Total a Pagar</button>
            <div id="totalPagar" class="mt-3" style="display:none;">
                <h4>Total a Pagar: <span id="totalAmount">0</span> </h4>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>

    <script>
        // Agregar un nuevo producto
        function agregarProducto() {
            const productosDiv = document.getElementById('productos');
            const nuevoProducto = productosDiv.firstElementChild.cloneNode(true);
            productosDiv.appendChild(nuevoProducto);
        }

        // Eliminar producto
        function eliminarProducto(button) {
            const productoRow = button.closest('.producto-row');
            productoRow.remove();
            calcularTotal(); // Recalcular el total después de eliminar un producto
        }

        // Calcular el total
        document.getElementById('calcularTotal').addEventListener('click', calcularTotal);

        function calcularTotal() {
            const productos = document.getElementsByName('productos[]');
            const cantidades = document.getElementsByName('cantidades[]');
            let total = 0;

            productos.forEach((producto, index) => {
                const productoId = producto.value;
                const cantidad = cantidades[index].value;
                if (productoId && cantidad) {
                    // Obtener el precio directamente desde los datos del select
                    const precio = producto.options[producto.selectedIndex].getAttribute('data-precio');
                    const subtotal = precio * cantidad;
                    total += subtotal;
                }
            });

            // Mostrar el total
            document.getElementById('totalAmount').textContent = total.toFixed(2);
            document.getElementById('totalPagar').style.display = 'block';
        }
    </script>
</body>
</html>
