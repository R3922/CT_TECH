<?php
session_start();
require 'conexion.php'; 



// Si se envía el formulario (botón "Generar Cotización")
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generar_cotizacion'])) {
  // 1. Recibir valores del formulario
  $nom_ven  = $_POST['nom_ven']  ?? '';
  $fecha    = $_POST['fecha']    ?? '';
  $correo   = $_POST['correo']   ?? '';
  $cliente  = $_POST['cliente']  ?? '';
  $giro     = $_POST['giro']     ?? '';
  $celular  = $_POST['celular']  ?? '';
  $contacto = $_POST['contacto'] ?? '';
  $rut      = $_POST['rut']      ?? '';
  $lugar    = $_POST['lugar']    ?? '';

  // 2. Preparar la sentencia INSERT usando los nombres reales de las columnas
  $sql = "INSERT INTO ct (nom_ven, fecha, correo, cliente, giro, celular, contacto, rut, lugar)
          VALUES (:nom_ven, :fecha, :correo, :cliente, :giro, :celular, :contacto, :rut, :lugar)";
  $stmt = $pdo->prepare($sql);

  // 3. Asignar parámetros
  $stmt->bindParam(':nom_ven',  $nom_ven);
  $stmt->bindParam(':fecha',    $fecha);
  $stmt->bindParam(':correo',   $correo);
  $stmt->bindParam(':cliente',  $cliente);
  $stmt->bindParam(':giro',     $giro);
  $stmt->bindParam(':celular',  $celular);
  $stmt->bindParam(':contacto', $contacto);
  $stmt->bindParam(':rut',      $rut);
  $stmt->bindParam(':lugar',    $lugar);

  // 4. Ejecutar la sentencia
  $stmt->execute();

  // 5. Obtener el ID recién insertado (id_ct)
  $id_ct = $pdo->lastInsertId();

  // 6. Formatear el ID con ceros a la izquierda (opcional)
  $displayNumber = str_pad($id_ct, 3, '0', STR_PAD_LEFT);

  // 7. Redirigir para evitar el reenvío del formulario al refrescar (PRG)
  header("Location: index.php?id_ct");
 
  exit;
}

// Si se accede a la página mediante GET y existe el parámetro 'cot_id', usamos ese número
if (isset($_GET['id_ct'])) {
  $displayNumber = $_GET['id_ct'];
} else {
  $displayNumber = "";
}

$cotizacion = [

  'Rut'           => '77.089.156-6',
  'Giro'          => 'Ingenieria, Productos y Servicios',
  'Dirección'     => 'Manuel Montt 480, Rancagua',
  'Tel'           => '+56 9 34697892',
  'Correo'        => 'ventas@tech-mining.cl',

  'servicio'      => 'A continuación se detalla el itimizado de cotización...',


  'observaciones' => "1) El cliente debe confirmar con OC (Orden de Compra).<br>"
    . '2) Esta oferta tiene una validez de 15 días.<br>'
    . '3) Esta cotización podrá ir acompañada de contrato y, condicionada a su aceptación.<br><br>'
    . 'TECHMINING SpA <br>'
    . '77.786.156-6 <br>'
    . 'Banco Santander <br>'
    . 'Cuenta Corriente <br>'
    . '0-000-8704294-4'

];



?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Cotización CT-<?php echo $displayNumber; ?></title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Se establece un ancho fijo para las etiquetas para lograr la misma separación */
    .header-table label {
      display: inline-block;
      width: 100px;
      /* Ajusta este valor según el espacio deseado */
    }

    /* Se eliminan los bordes de los inputs */
    .header-table input {
      border: none;
      outline: none;
    }
  </style>
</head>

<body>



  <div class="container">
    <!-- Encabezado principal -->
    <!-- Formulario que enviará datos a procesar.php -->
  <form  id="clientForm" action="procesar.php" method="POST" enctype="multipart/form-data">
    <header class="header-box">
      <div style="width: 50%; text-align: center;">
        <h1 style="margin: 0;">Cotización: CT-<?php echo $displayNumber; ?></h1>
        <p>
          <?php
          echo nl2br(htmlspecialchars($cotizacion['Rut'])) . '<br>' .
            nl2br(htmlspecialchars($cotizacion['Giro'])) . '<br>' .
            nl2br(htmlspecialchars($cotizacion['Dirección'])) . '<br>' .
            nl2br(htmlspecialchars($cotizacion['Tel'])) . '<br>' .
            nl2br(htmlspecialchars($cotizacion['Correo']));
          ?>
        </p>
        
        <!-- Enviamos también el número de cotización que se usará en la BD -->
        <input type="hidden" name="id_cot" value="<?php echo $displayNumber; ?>">

      </div>


      <!-- Si tuvieras un logo, podrías colocarlo aquí -->

      <div style="width: 60%; text-align: right; padding-right: 20px;">
        <img src="logo.jpg" alt="Logo de la Empresa" style="max-height: 75px;">
      </div>
    </header>


    <title>Formulario</title>
  <style>

    /* Tabla con separación entre columnas */
    .header-table {
      border-collapse: separate;
      border-spacing: 20px; /* Ajusta para mayor/menor espacio entre columnas */
      width: 100%;          /* Ocupa el ancho disponible */
    } 

    /* Definimos la columna izquierda con borde derecho para la línea vertical */
    .header-table col:nth-child(1) {
      border-right: 2px solid #ccc; /* Línea vertical estándar */
      width: 50%;
    }
    .header-table col:nth-child(2) {
      width: 50%;
    }

    
    /* Etiquetas en negrita y con un pequeño margen inferior */
    label {
      display: inline-block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    /* Inputs sin borde, solo línea inferior, con un ancho fijo para uniformidad */
    input[type="text"],
    input[type="email"] {
      border: none;
      border-bottom: 1px solid #ccc;
      padding: 5px;
      width: 200px; /* Ajusta el ancho a tu preferencia */
      box-sizing: border-box;
      outline: none;
    }
  </style>
</head>
<body>
 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ejemplo de Box</title>
  <style>
    .box {
      border: 1px solid #ccc;
      padding: 15px;
      background-color: #f9f9f9;
      width: 350px; /* Ajusta el ancho según necesites */
      margin: 2.5px 0 2.5px 2.5px; /* Centra el box y agrega márgenes */
    }
    
  </style>
</head>

  <body>
    <div class="box">
        <div class="box-content">
          <table>
            <tr>
              <td>
                <label for="vendedor">Vendedor:</label>
                <input type="text" name ='nom_ven' class="vendedor" placeholder="Nombre Vendedor">
               
              </td>
            </tr>
          </table>
      </div>
    </div>
  </body>
</html>
       
  
  <!-- Tabla con la información (Fecha, Cliente, etc.) -->
  <table class="header-table">
    <tr>
      <td>
        <label for="fecha">Fecha:</label>
        <input type="date" name = 'fecha' class="fecha">
      </td>
      <td>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" class="correo" placeholder="Ingrese el correo">
      </td>
    </tr>
    <tr>
      <td>
        <label for="cliente">Cliente:</label>
        <input type="text" name="cliente" class="cliente"  placeholder="Ingrese el nombre del cliente">
      </td>
      <td>
        <label for="giro">Giro:</label>
        <input type="text" name="giro" class="giro" placeholder="Ingrese actividad comercial">
      </td>
    </tr>
    <tr>
      <td>
        <label for="celular">Cell Phone:</label>
        <input type="text" name="celular" class="celular" placeholder="Ingrese número de teléfono">
      </td>
      <td>
        <label for="contacto">Contacto:</label>
        <input type="text" name="contacto" class="contacto" placeholder="Ingrese el contacto">
      </td>
    </tr>
    <tr>
      <td>
        <label for="rut">R.U.T:</label>
        <input type="text" name="rut" class="contacto" placeholder="Ingrese RUT">
      </td>
      <td>
        <label for="direccion">Dirección:</label>
        <input type="text" name="lugar" class="contacto" placeholder="Ingrese Dirección">
      </td>
    </tr>
  </table>
</body>
</html>


<!-- Separador -->
<hr>

<section class="service">
  <h2>Oferta del Servicio</h2>
  <p><?php echo nl2br(htmlspecialchars($cotizacion['servicio'])); ?></p>
  <!-- Aquí tu contenido de oferta, etc. -->
</section>

<div id="detalle-container">
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
        <!-- Única fila base (plantilla) -->
        <tr id="detalle-row">
          <td>
            <!-- El botón de comentarios se ubica junto al input "Detalle" -->
            <div style="display: flex; align-items: center; gap: 8px;">
              <input type="text" name = 'deta[]' class="detalle" placeholder="Detalle">
              <button type="button" class="comment-btn">Comentarios</button>
            </div>
          </td>
          <td>
            <input type="text" name = 'und[]' class="unidad" placeholder="Unidad">
          </td>
          <td>
            <input type="number" name = 'cant[]' class="cantidad" placeholder="Cantidad" min="0">
          </td>
          <td>
            <input type="number" name = 'prec[]' class="precio" placeholder="Precio" min="0">
          </td>
          <td>
            <input type="number" name="tot[]" class="total">
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Box de comentarios colocado debajo del box "detalle" -->
<div id="comments-box" style="display: none; margin-top: 10px;">
  <textarea placeholder="Escribe tus comentarios" style="width:100%; height: 100px;"></textarea>
  <br>
  <button id="close-comment-box" type="button">Cerrar Comentarios</button>
</div>

<!-- Contenedor para los botones de acción -->
<div class="detalle-buttons">
  <button id="cloneButton" type="button">Agregar Detalle</button>
  <button id="deleteButton" type="button" style="display: none;">Eliminar Detalle</button>
</div>

<!-- Inclusión de archivos JS externos -->
<script src="js/detalle.js"></script>
<script src="js/boton_comment.js"></script>
<script src="js/box_principal.js"></script>




<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Galería de Imágenes con Eliminación</title>
  <style>
    /* Estilos para la sección de la galería */
    .image-box {
      margin: 20px 0;
    }
    .image-box h3 {
      margin-bottom: 10px;
    }
    .images {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    /* Contenedor de cada imagen */
    .gallery-item {
      position: relative;
      display: inline-block;
    }
    .gallery-item img {
      width: 150px;
      height: auto;
      border: 1px solid #ccc;
      padding: 5px;
      border-radius: 4px;
      display: block;
    }
    /* Botón de eliminar en formato "×" */
    .delete-image {
      position: absolute;
      top: 2px;
      right: 2px;
      background: rgba(255, 0, 0, 0.8);
      color: #fff;
      border: none;
      padding: 0 5px;
      cursor: pointer;
      border-radius: 50%;
      font-size: 16px;
      line-height: 1;
    }
    .delete-image:hover {
      background: rgba(255, 0, 0, 1);
    }
    /* Estilos para la sección de inserción de imágenes */
    .upload-box {
      margin-top: 20px;
    }
    .upload-box input[type="file"] {
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <!-- Sección para la galería de imágenes -->
  <section class="image-box">
    <h3>Galería de Imágenes</h3>
    <div class="images" id="gallery">
    </div>
  </section>

  <!-- Sección para insertar nuevas imágenes -->
  <section class="upload-box">
    
    <input type="file" id="imageInput" accept="image/*">
    <button id="uploadButton" type="button">Insertar Imagen</button>
  </section>

  <script src="js/insert_image.js"></script>


</body>
</html>


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
  <td><?php echo nl2br($cotizacion['observaciones']); ?></td>


  <!-- Botón "Generar Cotización" con name="submit" -->
<div style="display: flex; justify-content: center; margin-top: 20px;">
  <button type="submit" name="generar_cotizacion"
          style="
            background-color: #28a745; 
            color: #fff; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px;
          ">
    Generar Cotización
  </button>
  
</div>
</form>

</section>
</div>

</body>

</html>





