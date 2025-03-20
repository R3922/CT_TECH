<?php
// Si NO estás usando la BD por ahora, define $cotizacion manualmente:
$cotizacion = [
    'numero'        => 'CT-123456',
    'fecha'         => '20-03-2025',
    'cliente'       => 'Cliente de Prueba',
    'lugar'         => 'Cliente de Prueba',
    'contacto'      => 'Cliente de Prueba',
    'correo'        => 'Cliente de Prueba',
    'servicio'      => 'Servicio de Ejemplo',
    
    
    'observaciones' => "Estas son observaciones de ejemplo.\nPuedes incluir varias líneas."
];

/*
   Si luego quieres usar la BD, harías algo como:
   -----------------------------------------------
   require_once 'conexion.php';
   $query = "SELECT numero, fecha, cliente, servicio, total_neto, iva, total, observaciones 
             FROM cotizaciones 
             WHERE id = :id";
   $stmt = $pdo->prepare($query);
   $stmt->execute(['id' => 1]);
   $cotizacion = $stmt->fetch();
   if (!$cotizacion) {
       die('Cotización no encontrada.');
   }
   -----------------------------------------------
*/

// Evita los warnings revisando que $cotizacion esté definido y sea un array:
if (!isset($cotizacion) || !is_array($cotizacion)) {
    die('No hay datos de cotización disponibles.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotización <?php echo htmlspecialchars($cotizacion['numero']); ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
    <!-- Encabezado principal -->
    <header class="header-box">
        <div class="header-left">
        <h1>Cotización: <?php echo htmlspecialchars($cotizacion['numero']); ?></h1>
        
        <!-- Tabla con la información (Fecha, Cliente, Lugar, etc.) -->
        <table class="header-table">
            <tr>
            <th>Fecha:</th>
            <td><?php echo htmlspecialchars($cotizacion['fecha']); ?></td>
            </tr>
            <tr>
            <th>Cliente:</th>
            <td><?php echo htmlspecialchars($cotizacion['cliente']); ?></td>
            </tr>
            <tr>
            <th>Lugar:</th>
            <td><?php echo htmlspecialchars($cotizacion['lugar']); ?></td>
            </tr>
            <tr>
            <th>Contacto:</th>
            <td><?php echo htmlspecialchars($cotizacion['contacto']); ?></td>
            </tr>
            <tr>
            <th>Correo:</th>
            <td><?php echo htmlspecialchars($cotizacion['correo']); ?></td>
            </tr>
        </table>
        </div>

      <!-- Si tuvieras un logo, podrías colocarlo aquí -->
      <div class="header-right">
        <img src="logo.jpg" alt="Logo de la Empresa"> 
      </div>
    </header>

    <!-- Separador -->
    <hr>

    <!-- Sección de servicio -->
    <section class="service">
    <h2>Oferta del Servicio</h2>
    <p><?php echo htmlspecialchars($cotizacion['servicio']); ?></p>
    </section>

    <!-- Contenedor para los boxes de detalle -->
    <div id="detalle-container">
    <!-- Box de Detalle para el servicio (plantilla original, sin botón de eliminar) -->
    <div class="detalle-box">
        <table class="detalle-table">
        <thead>
            <tr>
            <th>Detalle</th>
            <th>Unidad</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Fila de detalle con inputs para ingresar valores -->
            <tr>
           
            <td>
                <input type="text" class="detalle" value="" placeholder="">
            </td>
            <td>
                <input type="text" class="unidad" value="" placeholder="">
            </td>
            <td>
                <input type="number" class="cantidad" value="" placeholder="" min="0">
            </td>
            <td>
                <input type="number" class="precio" value="" placeholder="" step="any" min="0">
            </td>
            <td class="total">0.00</td>
            </tr>
        </tbody>
        </table>
    </div>
    </div>

    <!-- Contenedor para los botones de acción -->
    <div class="detalle-buttons">
    <button id="cloneButton" type="button">Agregar Detalle</button>
    <button id="deleteButton" type="button" style="display: none;">Eliminar Detalle</button>
    </div>

    <!-- Inclusión del archivo JS externo -->
    <script src="detalle.js"></script>

    </section>


    <!-- Sección para incluir imágenes -->
    <section class="image-box">
    <h3>Galería de Imágenes</h3>
    <div class="images">
        <img src="imagen1.jpg" alt="Imagen 1">
        <img src="imagen2.jpg" alt="Imagen 2">
        <!-- Agrega más imágenes según sea necesario -->
    </div>
    </section>


    <!-- Sección de totales en forma de tabla -->
    <section class="totals">
      <table>
        <tbody>
          <tr>
            <th>Total Neto</th>
            <td id="totalNeto"></td>
          </tr>
          <tr>
          
            <th>IVA (19%)</th>
            <td id="iva"></td>
          </tr>
          <tr>
            <th>Total</th>
            <td id="total"></td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Observaciones -->
    <section class="observations">
      <h3>Observaciones</h3>
      <!-- nl2br() convierte saltos de línea en <br> -->
      <p><?php echo nl2br(htmlspecialchars($cotizacion['observaciones'])); ?></p>
    </section>
  </div>
</body>
</html>
