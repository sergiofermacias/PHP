<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "tienda_producto"; // Ajusta si tu BD tiene otro nombre
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

$mensaje = "";

// Procesar el formulario de registro de producto
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['registrar_producto'])) {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

    $upload_dir = __DIR__ . "/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Imagen miniatura
    $imagen_miniatura = "";
    if (!empty($_FILES['imagen_miniatura']['name']) && $_FILES['imagen_miniatura']['error'] === 0) {
        $safe_name_mini = time() . "_mini_" . basename($_FILES['imagen_miniatura']['name']);
        $target_file_mini = $upload_dir . $safe_name_mini;

        if (move_uploaded_file($_FILES['imagen_miniatura']['tmp_name'], $target_file_mini)) {
            $imagen_miniatura = "uploads/" . $safe_name_mini;
        } else {
            $mensaje = "Error al subir la imagen miniatura.";
        }
    }

    // Imagen larga
    $imagen_larga = "";
    if (!empty($_FILES['imagen_larga']['name']) && $_FILES['imagen_larga']['error'] === 0) {
        $safe_name_larga = time() . "_lrg_" . basename($_FILES['imagen_larga']['name']);
        $target_file_larga = $upload_dir . $safe_name_larga;

        if (move_uploaded_file($_FILES['imagen_larga']['tmp_name'], $target_file_larga)) {
            $imagen_larga = "uploads/" . $safe_name_larga;
        } else {
            if (empty($mensaje)) $mensaje = "Error al subir la imagen larga.";
        }
    }

    // Insertar en BD
    $conn = conectarBD();
    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen_larga, imagen_miniatura) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $cantidad, $imagen_larga, $imagen_miniatura);
        if ($stmt->execute()) {
            $mensaje = "Producto registrado exitosamente.";
        } else {
            $mensaje = "Error al registrar el producto: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Error al preparar la consulta: " . $conn->error;
    }
    $conn->close();
}

// Eliminar producto
if (isset($_GET['eliminar_id'])) {
    $producto_id = intval($_GET['eliminar_id']);
    if ($producto_id > 0) {
        $conn = conectarBD();
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $producto_id);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }
    header("Location: registro_producto.php");
    exit();
}

// Obtener productos
function obtenerProductos() {
    $conn = conectarBD();
    $sql = "SELECT * FROM productos ORDER BY id DESC";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

$productos = obtenerProductos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Producto</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <style>
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .user-area { text-align:right; }
        .btn { background-color:#007BFF; color:#fff; padding:8px 12px; border:none; border-radius:5px; cursor:pointer; text-decoration:none; }
        .btn-danger { background-color:#e74c3c; }
        .btn-small { padding:6px 10px; font-size:14px; }
        .btn-gray { background-color:#6c757d; }
        .btn-green { background-color:#28a745; }
        .message { margin: 10px 0; padding:10px; border-radius:6px; background:#e9f7ef; color:#155724; }
        table img { display:block; }
    </style>
</head>
<body>
    <div class="topbar">
        <div>
            <h2>Formulario de Registro de Producto</h2>
        </div>
        <div class="user-area">
            Usuario: <strong><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '---'; ?></strong>
            &nbsp;|&nbsp;
            <!-- Botón ver historial -->
            <a class="btn btn-small btn-green" href="ver_logs.php">📜 Ver historial de inicio de sesión</a>
            &nbsp;
            <!-- Botón cerrar sesión -->
            <a class="btn btn-small btn-danger" href="logout.php">Cerrar sesión</a>
            &nbsp;
            <!-- Botón volver al login -->
            <a class="btn btn-small btn-gray" href="login.php">Volver al inicio de sesión</a>
        </div>
    </div>

    <?php if (!empty($mensaje)): ?>
        <div class="message"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form action="registro_producto.php" method="post" enctype="multipart/form-data" style="max-width:600px; margin-bottom:30px;">
        <label for="nombre">Nombre del producto</label><br>
        <input type="text" name="nombre" id="nombre" required style="width:100%; padding:8px;"><br><br>

        <label for="descripcion">Descripción</label><br>
        <textarea name="descripcion" id="descripcion" required style="width:100%; padding:8px; height:100px;"></textarea><br><br>

        <label for="precio">Precio</label><br>
        <input type="number" step="0.01" name="precio" id="precio" required style="width:200px; padding:8px;"><br><br>

        <label for="cantidad">Cantidad</label><br>
        <input type="number" name="cantidad" id="cantidad" required style="width:200px; padding:8px;"><br><br>

        <label for="imagen_larga">Imagen larga</label><br>
        <input type="file" name="imagen_larga" id="imagen_larga" accept="image/*"><br><br>

        <label for="imagen_miniatura">Imagen miniatura</label><br>
        <input type="file" name="imagen_miniatura" id="imagen_miniatura" accept="image/*" required><br><br>

        <input type="submit" name="registrar_producto" value="Registrar Producto" class="btn">
    </form>

    <h3>Productos Registrados</h3>
    <?php if ($productos && $productos->num_rows > 0): ?>
        <table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">
            <thead style="background:#f0f0f0;">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Miniatura</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($producto = $productos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['id']); ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                        <td style="text-align:center;">
                            <?php if (!empty($producto['imagen_miniatura'])): ?>
                                <a href="<?php echo htmlspecialchars($producto['imagen_larga'] ?: $producto['imagen_miniatura']); ?>" target="_blank">
                                    <img src="<?php echo htmlspecialchars($producto['imagen_miniatura']); ?>" alt="Miniatura" width="80">
                                </a>
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="editar_producto.php?id=<?php echo $producto['id']; ?>">Editar</a> |
                            <a href="?eliminar_id=<?php echo $producto['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?');" style="color:#c0392b;">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay productos registrados.</p>
    <?php endif; ?>
</body>
</html>
