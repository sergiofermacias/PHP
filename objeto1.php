<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica con Objetos en PHP</title>
</head>
<body>

<?php
// ================== OBJETO 1: LOGIN ==================
class Login {
    public function mostrarFormulario() {
        echo '<h2>Formulario de Login</h2>';
        echo '<form method="post" action="">';
        echo '<label for="usuario">Usuario: </label>';
        echo '<input type="text" id="usuario" name="usuario" required><br><br>';
        echo '<label for="password">Contraseña: </label>';
        echo '<input type="password" id="password" name="password" required><br><br>';
        echo '<input type="submit" name="login" value="Ingresar">';
        echo '</form><hr>';
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["login"])) {
            $usuario = $_POST["usuario"];
            $password = $_POST["password"];

            echo "<h3>Datos recibidos (Login):</h3>";
            echo "Usuario: " . htmlspecialchars($usuario) . "<br>";
            echo "Contraseña: " . htmlspecialchars($password) . "<br><hr>";
        }
    }
}

// ================== OBJETO 2: REGISTRO ==================
class RegistroPersona {
    public function mostrarFormulario() {
        echo '<h2>Formulario de Registro</h2>';
        echo '<form method="post" action="">';
        echo '<label for="nombre">Nombre: </label>';
        echo '<input type="text" id="nombre" name="nombre" required><br><br>';
        echo '<label for="apellido">Apellido: </label>';
        echo '<input type="text" id="apellido" name="apellido" required><br><br>';
        echo '<label for="fecha">Fecha de Nacimiento: </label>';
        echo '<input type="date" id="fecha" name="fecha" required><br><br>';
        echo '<label>Sexo: </label>';
        echo '<input type="radio" id="masculino" name="sexo" value="masculino" required>';
        echo '<label for="masculino">Masculino</label>';
        echo '<input type="radio" id="femenino" name="sexo" value="femenino" required>';
        echo '<label for="femenino">Femenino</label><br><br>';
        echo '<input type="submit" name="registro" value="Registrar">';
        echo '</form><hr>';
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["registro"])) {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $fecha = $_POST["fecha"];
            $sexo = $_POST["sexo"];

            echo "<h3>Datos recibidos (Registro):</h3>";
            echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
            echo "Apellido: " . htmlspecialchars($apellido) . "<br>";
            echo "Fecha Nacimiento: " . htmlspecialchars($fecha) . "<br>";
            echo "Sexo: " . htmlspecialchars($sexo) . "<br><hr>";
        }
    }
}

// ================== EJECUCIÓN ==================
$login = new Login();
$registro = new RegistroPersona();

$login->mostrarFormulario();
$registro->mostrarFormulario();

$login->procesarFormulario();
$registro->procesarFormulario();
?>

</body>
</html>