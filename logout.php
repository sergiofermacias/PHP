<?php
session_start();

// Conexión a la BD
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "tienda_producto";
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si la sesión está activa, actualizamos logout_time
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (isset($_SESSION['sesion_id'])) {
        $sesion_id = $_SESSION['sesion_id'];

        $sql = "UPDATE log_sistema 
                SET logout_time = NOW() 
                WHERE session_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sesion_id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

// Destruir sesión
session_unset();
session_destroy();

// Redirigir al login
header("Location: login.php");
exit;
?>
