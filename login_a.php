<?php
session_start();

// ---------- FUNCIÓN CONEXIÓN ----------
function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php"; 
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

// ---------- PROCESO DE LOGIN ----------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Por favor ingrese usuario y contraseña";
    } else {
        $conn = conectarBD();

        $sql = "SELECT id, username, password FROM login_user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verificación de contraseña
            if ($password === $user['password'] || md5($password) === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['loggedin'] = true;

                // Guardar sesión en historial
                $session_id = session_id();
                $fecha = date("Y-m-d");
                $hora = date("H:i:s");

                $sql_historial = "INSERT INTO sesiones_historial (user_id, session_id, fecha_inicio, hora_inicio) 
                                  VALUES (?, ?, ?, ?)";
                $stmt_historial = $conn->prepare($sql_historial);
                $stmt_historial->bind_param("isss", $user['id'], $session_id, $fecha, $hora);
                $stmt_historial->execute();
                $stmt_historial->close();

                header("Location: conexionBD_leer_registrar_eliminar_editar_css_sesion.php");
                exit;
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "Usuario no encontrado";
        }

        $stmt->close();
        $conn->close();
    }
}

// ---------- CERRAR SESIÓN ----------
if (isset($_GET['logout'])) {
    if (isset($_SESSION['user_id'])) {
        $conn = conectarBD();
        $session_id = session_id();
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $sql_update = "UPDATE sesiones_historial 
                       SET fecha_cierre = ?, hora_cierre = ? 
                       WHERE session_id = ? AND user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $fecha, $hora, $session_id, $_SESSION['user_id']);
        $stmt_update->execute();
        $stmt_update->close();
        $conn->close();
    }

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 380px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #222;
            font-size: 1.6rem;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.95rem;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" name="login">Entrar</button>
        </form>

        <a href="historial.php">📜 Ver historial de sesiones</a>
    </div>
</body>
</html>
