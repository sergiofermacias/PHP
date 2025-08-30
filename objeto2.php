<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <!-- Formulario HTML -->
    <form action="Objeto2.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text"id="nombre" name="nombre" required><br><br>
        <label for="apellido">Apellido:</label>
        <input type="text" id="Estado civil" name="apellido" required><br><br>
        <label for="fechanto">Fecha Nto:</label>
        <input type="date" id="fechanto" name="fechanto" required><br><br>
        <label for="sexo">Edad:</label>
        <label for="genero">Género:</label>
            <div>
            <input type="radio" id="masculino" name="genero" value="masculino">
            <label for="masculino">Masculino</label>
            </div>
            <div>
             <input type="radio" id="femenino" name="genero" value="femenino">
            <label for="femenino">Femenino</label>
             </div>
        <input type="submit" value="Enviar">
        
    </form>

    <?php
    //Procesamiento del formulario PHP - Servidor
    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $fechanto = $_POST["fechanto"];
        $genero = $_POST["genero"];
        echo "Nombre: " . $nombre . "<br>";
        echo "Apellido: " . $apellido . "<br>";
        echo "Fecha Nto: " . $fechanto . "<br>";
        echo "Genero: " . $genero ;
    }

    ?>
</body>
</html>