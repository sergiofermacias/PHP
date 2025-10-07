<?php
// Conexión a la base de datos
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "tienda_producto";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta
$sql = "SELECT session_id, username, login_time, logout_time FROM log_sistema ORDER BY login_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Sesiones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .null {
            color: red;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Historial de Sesiones</h1>
    <table>
        <tr>
            <th>ID Sesión</th>
            <th>Usuario</th>
            <th>Inicio de Sesión</th>
            <th>Cierre de Sesión</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["session_id"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["login_time"] . "</td>";
                echo "<td>" . ($row["logout_time"] ? $row["logout_time"] : "<span class='null'>Activo</span>") . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay registros</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
