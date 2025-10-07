<?php
session_start();

// Regenerar siempre un nuevo session_id para evitar duplicados
session_regenerate_id(true);

// Conexión a la BD
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "tienda_producto";
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para validar usuario
    $sql = "SELECT * FROM login_user WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Usuario válido → iniciar sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Obtener y guardar el session_id generado por PHP
        $sesion_id = session_id();
        $_SESSION['sesion_id'] = $sesion_id;

        // Registrar en log_sistema
        $sql_log = "INSERT INTO log_sistema (session_id, username, login_time) 
                    VALUES (?, ?, NOW())";
        $stmt_log = $conn->prepare($sql_log);
        $stmt_log->bind_param("ss", $sesion_id, $username);
        $stmt_log->execute();
        $stmt_log->close();

        // Redirigir al formulario de productos
        header("Location: registro_producto.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>

    <?php if (isset($error)): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" name="login" value="Iniciar Sesión">
    </form>

    <p>¿No tienes cuenta? <a href="registro_usuario.php">Regístrate aquí</a></p>
</body>
</html>
