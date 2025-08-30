<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase de PHP</title>
</head>
<body>
    <?php 
    // Esto es un ejercicio de variable en php_check_syntax
    // estos son array  
        $array = array("uno ", "dos ", "tres");
        echo "<h1>Array de ejemplo:</h1>";
        echo "<p>Los elementos: " . $array[0] . "," . $array[1] . " y " . $array[2] . "</p>";

    
        //Ejercicio de operadores aritmeticos.

        $a = 10;
        $b = 5;
        $suma = $a + $b;
        $resta = $a - $b;
        $multiplicacion = $a * $b;
        $division = $a / $b;

        echo "<h1>Operadores aritmeticos</h1>";
        echo "<p>La suma de $a y $b es: $suma</p>";
        echo "<p>La resta de $a y $b es: $resta</p>";
        echo "<p>La multiplicacion de $a y $b es: $multiplicacion</p>";
        echo "<p>La division de $a y $b es: $division</p>";

        // Ejercicio_Familia

        $Padres = 2;
        $hijos = 5;
        $nietos = 2;

        $suma = $Padres + $hijos + $nietos;
        $multiplicacion = $nietos * 5;
        $total = $suma + $multiplicacion;
        $resta = $total - 3;
       
        
        echo "<h1>Resultado familia</h1>";
        echo "<p>La suma de la primera familia son: $suma</p>";
        echo "<p>Total de bisnietos son: $multiplicacion</p>";
        echo "<p>Total de toda la familia son: $total</p>";
        echo "<p>Total familia con sus fallecidos: $resta</p>";
    
        //Determinar el numero mayor de tres numeros

        $num1 = 15;
        $num2 = 14;
        $num3 = 20;

        if ($num1 >$num2 && $num1 > $num3) {
            echo "el numero mayor es: $num1";
        } elseif ($num2 > $num1 && $num2 > $num3) {
            echo "el numero mayor es: $num2";
        } else {
            echo "el numero mayor es: $num3"
        }


    ?>
</body>
</html>