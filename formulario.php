<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <!-- Formulario HTML -->
    <form action="formulario.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text"id="nombre" name="nombre" required><br><br>
        <label for="apellido">Apellido:</label>
        <input type="text" id="Estado civil" name="apellido" required><br><br>
        <label for="apellido">Estado civil:</label>
        <input type="text" id="estadocivil" name="estadocivil" required><br><br>
        <label for="edad">Edad:</label>
        <input type="text" id="edad" name="edad" required><br><br>
        <label for="estatura">Estatura:</label>
        <input type="text" id="estatura" name="estatura" required><br><br>
        <input type="submit" value="Enviar">
        
    </form>

    <?php
    //Procesamiento del formulario PHP - Servidor
    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $estadocivil = $_POST["estadocivil"];
        $edad = $_POST["edad"];
        $estatura = $_POST["estatura"];
        echo "Nombre: " . $nombre . "<br>";
        echo "Apellido: " . $apellido . "<br>";
        echo "Estado civil: " . $estadocivil . "<br>";
        echo "Edad: " . $edad . "<br>";
        echo "Estatura: " . $estatura ;
    }

    ?>
</body>
</html> 