<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Promedio con Bonificación por Género</title>
    <link rel="stylesheet" href="consulta3.css"> 
    <style>
        /* Estilos básicos para la visualización */
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-container, .resultado {
            max-width: 550px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }
        .notas-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        button {
            background-color: #ff5733;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .resultado {
            background-color: #f0fff0;
            border: 1px solid #28a745;
        }
        .resultado p {
            margin: 10px 0;
        }
        .resaltado {
            font-size: 1.3em;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Calculadora de Bonificación por Género</h1>
        
        <form action="" method="POST"> 
            
            <div class="form-group">
                <label for="nombre">Nombre del Alumno</label>
                <input type="text" id="nombre" name="nombre" value="EKEO" required>
            </div>

            <div class="form-group">
                <label for="genero">Género</label>
                <select id="genero" name="genero" required>
                    <option value="" disabled>Seleccione el género</option>
                    <option value="MASCULINO" selected>MASCULINO</option>
                    <option value="FEMENINO">FEMENINO</option>
                </select>
            </div>

            <label>Notas (0 a 20):</label>
            <div class="notas-grid">
                <input type="number" name="n1" placeholder="N1" value="16" min="0" max="20" required>
                <input type="number" name="n2" placeholder="N2" value="13" min="0" max="20" required>
                <input type="number" name="n3" placeholder="N3" value="10" min="0" max="20" required>
                <input type="number" name="n4" placeholder="N4" value="12" min="0" max="20" required>
            </div>

            <button type="submit" name="calcular">Calcular Promedio Final</button>
        </form>
    </div>

    <?php
    // =========================================================================
    // Lógica PHP para PROCESAR el Formulario
    // =========================================================================
    
    // 1. Verificamos si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        
        // 2. Capturamos los datos
        $nombre = strtoupper(htmlspecialchars($_POST['nombre']));
        $genero = strtoupper($_POST['genero']);
        $n1 = floatval($_POST['n1']);
        $n2 = floatval($_POST['n2']);
        $n3 = floatval($_POST['n3']);
        $n4 = floatval($_POST['n4']);
        
        $bonificacion = 0;

        // 3. Calcular el Promedio Final (PF) sin bonificación
        $promedio_final = ($n1 + $n2 + $n3 + $n4) / 4;
        
        // 4. Determinar la bonificación según el género
        if ($genero === 'MASCULINO') {
            $bonificacion = 3;
        } else {
            // FEMENINO o cualquier otro valor
            $bonificacion = 5;
        }

        // 5. Calcular el Nuevo Promedio Final (NP) con bonificación
        $nuevo_promedio = $promedio_final + $bonificacion;

        // 6. Mostramos los resultados al usuario
        ?>
        <div class="resultado">
            <h2>Resultados para el Alumno <?php echo $nombre; ?></h2>
            <p>Género: <span class="resaltado"><?php echo $genero; ?></span></p>
            <p>Promedio Final (PF) sin bonificación: <span class="resaltado"><?php echo number_format($promedio_final, 2); ?></span></p>
            <p>Bonificación aplicada: <span class="resaltado">+ <?php echo $bonificacion; ?> puntos</span></p>
            <p>........................</p>
            <p>El **Nuevo Promedio Final (NP)** es: <span class="resaltado" style="color: green;"><?php echo number_format($nuevo_promedio, 2); ?></span></p>
        </div>
        <?php
    }
    // Si no se ha enviado el formulario, solo se muestra el formulario HTML.
    ?>

</body>
</html>