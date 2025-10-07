<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usuario_php");

$result = $conn->query("SELECT h.*, u.username 
                        FROM sesiones_historial h
                        INNER JOIN login_user u ON h.user_id = u.id
                        ORDER BY h.id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Sesiones</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #007bff; color: #fff; }
        tr:nth-child(even) { background: #f2f2f2; }
        h2 { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Historial de Sesiones</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Session ID</th>
            <th>Fecha Inicio</th>
            <th>Hora Inicio</th>
            <th>Fecha Cierre</th>
            <th>Hora Cierre</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['session_id'] ?></td>
            <td><?= $row['fecha_inicio'] ?></td>
            <td><?= $row['hora_inicio'] ?></td>
            <td><?= $row['fecha_cierre'] ?: "-" ?></td>
            <td><?= $row['hora_cierre'] ?: "-" ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
