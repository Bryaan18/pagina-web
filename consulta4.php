<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Sueldo con Retención</title>
    <link rel="stylesheet" href="consulta4.css"> 
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
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }
        .datos-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        button {
            background-color: #0099cc;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .resultado {
            background-color: #e6f7ff;
            border: 1px solid #0099cc;
        }
        .resultado p {
            margin: 10px 0;
        }
        .resaltado {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
        .neto {
            font-size: 1.5em;
            color: #28a745;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Calculadora de Sueldo</h1>
        
        <form action="" method="POST"> 
            
            <div class="form-group">
                <label for="nombre">Nombre del Trabajador</label>
                <input type="text" id="nombre" name="nombre" value="EKEKO" required>
            </div>

            <div class="datos-grid">
                <div class="form-group">
                    <label for="horas">Horas Trabajadas</label>
                    <input type="number" id="horas" name="horas" placeholder="ej: 130" value="130" min="0" required>
                </div>
                <div class="form-group">
                    <label for="pago">Pago por Hora ($)</label>
                    <input type="number" id="pago" name="pago" placeholder="ej: 20" value="20" min="0" step="0.01" required>
                </div>
            </div>

            <button type="submit" name="calcular">Calcular Pago Total</button>
        </form>
    </div>

    <?php
    // =========================================================================
    // Lógica PHP para PROCESAR el Formulario
    // =========================================================================
    
    // 1. Verificamos si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        
        // 2. Capturamos y convertimos los datos
        $nombre = strtoupper(htmlspecialchars($_POST['nombre']));
        $horas_trabajadas = floatval($_POST['horas']);
        $pago_por_hora = floatval($_POST['pago']);
        
        $retencion = 0;
        $tasa_retencion = 0.10; // 10%
        $umbral_retencion = 1500;

        // 3. Calcular el Sueldo Bruto (SB)
        // SB = Horas Trabajadas * Pago por Hora
        $sueldo_bruto = $horas_trabajadas * $pago_por_hora;
        
        // 4. Determinar la Retención (RETE)
        // Si SB > 1500, hay retención del 10%. En caso contrario, es 0.
        if ($sueldo_bruto > $umbral_retencion) {
            $retencion = $sueldo_bruto * $tasa_retencion;
            $mensaje_retencion = "Se aplicó retención del " . ($tasa_retencion * 100) . "% por superar los $$umbral_retencion.";
        } else {
            $retencion = 0;
            $mensaje_retencion = "No hay retención. Sueldo bruto es $$sueldo_bruto (menor o igual a $$umbral_retencion).";
        }

        // 5. Calcular el Sueldo Neto (SN)
        // SN = SB - RETE
        $sueldo_neto = $sueldo_bruto - $retencion;

        // 6. Imprimimos los resultados
        ?>
        <div class="resultado">
            <h2>Resultados para <?php echo $nombre; ?></h2>
            <p>Horas Trabajadas: <span class="resaltado"><?php echo $horas_trabajadas; ?></span></p>
            <p>Pago por Hora: <span class="resaltado">$<?php echo number_format($pago_por_hora, 2); ?></span></p>
            <p>........................</p>
            
            <p>Sueldo Bruto (SB): <span class="resaltado">$<?php echo number_format($sueldo_bruto, 2); ?></span></p>
            <p>Retención (RETE): <span class="resaltado" style="color: red;">$<?php echo number_format($retencion, 2); ?></span></p>
            <p style="font-size: 0.9em; color: gray; margin-top: -10px;"><?php echo $mensaje_retencion; ?></p>
            
            <p>........................</p>
            <p>El **Sueldo Neto (SN)** es: <span class="resaltado neto">$<?php echo number_format($sueldo_neto, 2); ?></span></p>
        </div>
        <?php
    }
    // Si no se ha enviado el formulario, solo se muestra el formulario HTML.
    ?>

</body>
</html>