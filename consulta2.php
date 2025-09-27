<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Costo de Llamadas Internacionales</title>
    <link rel="stylesheet" href="consulta2.css"> 
    <style>
        /* Estilos básicos para la visualización */
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-container, .resultado, .tabla-precios {
            max-width: 600px;
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
        .tabla-precios table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .tabla-precios th, .tabla-precios td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .tabla-precios th {
            background-color: #eee;
        }
    </style>
</head>
<body>

    <div class="tabla-precios">
        <h2>Tabla de Costos por Zona</h2>
        <table>
            <thead>
                <tr><th>Clave</th><th>Zona</th><th>Precio por Minuto</th></tr>
            </thead>
            <tbody>
                <tr><td>12</td><td>América del Norte</td><td>2.1</td></tr>
                <tr><td>15</td><td>América Central</td><td>2.6</td></tr>
                <tr><td>18</td><td>América del Sur</td><td>4.5</td></tr>
                <tr><td>19</td><td>Europa</td><td>3.6</td></tr>
                <tr><td>23</td><td>Asia</td><td>6.5</td></tr>
                <tr><td>25</td><td>África</td><td>7.8</td></tr>
                <tr><td>29</td><td>Oceanía</td><td>3.9</td></tr>
            </tbody>
        </table>
    </div>

    <div class="form-container">
        <h1>Calculadora de Llamadas</h1>
        <form action="" method="POST"> 
            
            <div class="form-group">
                <label for="clave_zona">Clave de la Zona de Destino</label>
                <select id="clave_zona" name="clave_zona" required>
                    <option value="" disabled selected>Seleccione la clave</option>
                    <option value="12">12 - América del Norte</option>
                    <option value="15">15 - América Central</option>
                    <option value="18">18 - América del Sur</option>
                    <option value="19">19 - Europa</option>
                    <option value="23">23 - Asia</option>
                    <option value="25">25 - África</option>
                    <option value="29">29 - Oceanía</option>
                </select>
            </div>

            <div class="form-group">
                <label for="minutos">Minutos Hablados</label>
                <input type="number" id="minutos" name="minutos" value="10" min="1" required>
            </div>

            <button type="submit" name="calcular">Calcular Costo Total</button>
        </form>
    </div>

    <?php
    // =========================================================================
    // Lógica PHP para PROCESAR el Formulario
    // =========================================================================
    
    // Definimos el array de precios que simula tu tabla
    $precios_por_zona = [
        '12' => ['zona' => 'América del Norte', 'precio' => 2.1],
        '15' => ['zona' => 'América Central', 'precio' => 2.6],
        '18' => ['zona' => 'América del Sur', 'precio' => 4.5],
        '19' => ['zona' => 'Europa', 'precio' => 3.6],
        '23' => ['zona' => 'Asia', 'precio' => 6.5],
        '25' => ['zona' => 'África', 'precio' => 7.8],
        '29' => ['zona' => 'Oceanía', 'precio' => 3.9],
    ];

    // 1. Verificamos si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        
        // 2. Capturamos y validamos los datos del formulario
        $clave = $_POST['clave_zona'];
        $minutos = intval($_POST['minutos']);
        $costo_total = 0;
        $zona_destino = "N/A";
        $precio_minuto = 0;

        // 3. Buscamos el precio en la "tabla" (array) usando la clave
        if (array_key_exists($clave, $precios_por_zona)) {
            $precio_minuto = $precios_por_zona[$clave]['precio'];
            $zona_destino = $precios_por_zona[$clave]['zona'];
            
            // 4. Calculamos el costo total
            $costo_total = $minutos * $precio_minuto;
        } else {
            $zona_destino = "Clave no válida";
            $costo_total = 0;
        }

        // 5. Mostramos los resultados al usuario
        ?>
        <div class="resultado">
            <h2>Detalle de la Llamada</h2>
            <p>Clave de Zona Ingresada: <span class="resaltado"><?php echo htmlspecialchars($clave); ?></span></p>
            <p>Zona de Destino: <span class="resaltado"><?php echo htmlspecialchars($zona_destino); ?></span></p>
            <p>Minutos Hablados: <span class="resaltado"><?php echo $minutos; ?></span></p>
            <p>Precio por Minuto: <span class="resaltado">$<?php echo number_format($precio_minuto, 2); ?></span></p>
            <p>........................</p>
            <p>El **Costo Total** es: <span class="resaltado" style="color: green;">$<?php echo number_format($costo_total, 2); ?></span></p>
        </div>
        <?php
    }
    // Si no se ha enviado el formulario, solo se muestra la tabla y el formulario.
    ?>

</body>
</html>