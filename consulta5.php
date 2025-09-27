<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Derecho de Examen de Admisión</title>
    <link rel="stylesheet" href="consulta1.css"> 
    <style>
        /* Estilos básicos */
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-container, .resultado {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }
        button {
            background-color: #f7a01a; /* Naranja/Amarillo universitario */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .resultado {
            background-color: #fff8e1;
            border: 1px solid #f7a01a;
        }
        .resultado p {
            margin: 10px 0;
        }
        .resaltado {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
        .pago-final {
            font-size: 1.5em;
            color: #d9534f; /* Rojo/Naranja para el costo final */
        }
        .costo-base {
            background-color: #e9e9e9;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Cálculo de Derecho de Examen de Admisión</h1>
        
        <?php $costo_base = 285.00; ?>
        <div class="costo-base">
            Costo Base del Examen: <span class="resaltado">$<?php echo number_format($costo_base, 2); ?></span>
        </div>

        <form action="" method="POST"> 
            
            <div class="form-group">
                <label for="procedencia">Procedencia del Colegio del Postulante</label>
                <select id="procedencia" name="procedencia" required>
                    <option value="" disabled selected>Seleccione la procedencia</option>
                    <option value="NACIONAL">Colegio NACIONAL (10% Dcto.)</option>
                    <option value="PARTICULAR">Colegio PARTICULAR (3% Dcto.)</option>
                </select>
            </div>

            <button type="submit" name="calcular">Calcular Importe a Pagar</button>
        </form>
    </div>

    <?php
    // =========================================================================
    // Lógica PHP para PROCESAR el Formulario
    // =========================================================================
    
    // 1. Verificamos si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        
        // 2. Capturamos los datos
        $procedencia = strtoupper($_POST['procedencia']);
        $descuento_porcentaje = 0;
        
        // 3. Determinar el porcentaje de descuento según la procedencia
        if ($procedencia === 'NACIONAL') {
            $descuento_porcentaje = 0.10; // 10%
        } elseif ($procedencia === 'PARTICULAR') {
            $descuento_porcentaje = 0.03; // 3%
        } else {
            // Caso por si el valor no es reconocido (aunque el select lo limita)
            $descuento_porcentaje = 0;
        }

        // 4. Calcular el monto del descuento
        $monto_descuento = $costo_base * $descuento_porcentaje;

        // 5. Calcular el Importe Final a Pagar
        $importe_final = $costo_base - $monto_descuento;

        // 6. Imprimimos los resultados
        ?>
        <div class="resultado">
            <h2>Importe a Pagar (Detalle)</h2>
            <p>Costo Base del Examen: <span class="resaltado">$<?php echo number_format($costo_base, 2); ?></span></p>
            <p>Procedencia: <span class="resaltado"><?php echo $procedencia; ?></span></p>
            <p>Descuento Aplicado: <span class="resaltado"><?php echo ($descuento_porcentaje * 100); ?>%</span></p>
            <p>Monto del Descuento: <span class="resaltado" style="color: green;">-$<?php echo number_format($monto_descuento, 2); ?></span></p>
            <p>........................</p>
            <p>El **Importe Final a Pagar** es: <span class="resaltado pago-final">$<?php echo number_format($importe_final, 2); ?></span></p>
        </div>
        <?php
    }
    // Si no se ha enviado el formulario, solo se muestra el formulario HTML.
    ?>

</body>
</html>