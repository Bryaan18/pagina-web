<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Sueldo con Formulario PHP</title>
    <link rel="stylesheet" href="consulta1.css">
    <style>
        /* Estilos básicos para la visualización */
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-container, .resultado {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .resultado {
            background-color: #f9f9f9;
            border: 1px solid #28a745;
        }
        .resultado p {
            margin: 5px 0;
        }
        .resaltado {
            font-size: 1.2em;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Calculadora de Sueldo por Categoría</h1>

        <form action="" method="POST"> 
            
            <div class="form-group">
                <label for="sueldo_base">Sueldo Base ($)</label>
                <input type="number" id="sueldo_base" name="sueldo_base" value="1000" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="1" selected>Categoría 1 (Aumento 30%)</option>
                    <option value="2">Categoría 2 (Aumento 20%)</option>
                    <option value="3">Categoría 3 (Aumento 15%)</option>
                    <option value="4">Otras Categorías (Sin aumento)</option>
                </select>
            </div>

            <button type="submit" name="calcular">Calcular Nuevo Sueldo</button>
        </form>
    </div>

    <?php
    // =========================================================================
    // Lógica PHP para PROCESAR el Formulario
    // =========================================================================
    
    // 1. Verificamos si el formulario fue enviado (si el botón 'calcular' existe en la petición POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        
        // 2. Capturamos los datos del formulario de manera segura
        $sueldo = floatval($_POST['sueldo_base']);
        $categoria = intval($_POST['categoria']);
        $Nsueldo = 0;
        $porcentaje = 0;

        // 3. Aplicamos la lógica de cálculo de sueldo
        if ($categoria == 1) {
            $porcentaje = 0.30;
        } elseif ($categoria == 2) {
            $porcentaje = 0.20;
        } elseif ($categoria == 3) {
            $porcentaje = 0.15;
        } else {
            // Categoría 4 o cualquier otra (sin aumento)
            $porcentaje = 0; 
        }

        // Calculamos el nuevo sueldo
        $Nsueldo = $sueldo * (1 + $porcentaje);

        // 4. Mostramos los resultados al usuario en HTML
        ?>
        <div class="resultado">
            <h2>Resultados del Cálculo</h2>
            <p>El sueldo base es: <span class="resaltado"><?php echo number_format($sueldo, 2); ?> $</span></p>
            <p>Categoría seleccionada: <span class="resaltado"><?php echo $categoria; ?></span></p>
            <p>Porcentaje de aumento: <span class="resaltado"><?php echo $porcentaje * 100; ?>%</span></p>
            <p>........................</p>
            <p>El **Nuevo Sueldo** es: <span class="resaltado" style="color: green;"><?php echo number_format($Nsueldo, 2); ?> $</span></p>
        </div>
        <?php
    }
    // Si no se ha enviado el formulario, solo se muestra el formulario HTML de arriba.
    ?>

</body>
</html>