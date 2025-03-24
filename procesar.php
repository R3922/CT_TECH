<?php

require 'conexion.php'; // Conexión a la base de datos



// 2. Recoger datos de la tabla CT
$nom_ven = $_POST['nom_ven'] ?? '';
$fecha   = $_POST['fecha']   ?? '';
$correo  = $_POST['correo']  ?? '';
$cliente = $_POST['cliente'] ?? '';
$giro    = $_POST['giro']    ?? '';
$celular = $_POST['celular'] ?? '';
$contacto= $_POST['contacto']?? '';
$rut     = $_POST['rut']     ?? '';
$lugar   = $_POST['lugar']   ?? '';

// 3. Insertar en tabla CT
$sqlCT = "INSERT INTO CT (nom_ven, fecha, correo, cliente, giro, celular, contacto, rut, lugar)
          VALUES (:nom_ven, :fecha, :correo, :cliente, :giro, :celular, :contacto, :rut, :lugar)";
$stmt = $pdo->prepare($sqlCT);
$stmt->execute([
    ':nom_ven'  => $nom_ven,
    ':fecha'    => $fecha,
    ':correo'   => $correo,
    ':cliente'  => $cliente,
    ':giro'     => $giro,
    ':celular'  => $celular,
    ':contacto' => $contacto,
    ':rut'      => $rut,
    ':lugar'    => $lugar
]);
// Obtenemos el id_ct (PK autoincrement)
$id_ct = $pdo->lastInsertId();

// 4. Insertar detalles en DETALLE
$deta  = $_POST['deta']  ?? [];  // array
$und   = $_POST['und']   ?? [];
$cant  = $_POST['cant']  ?? [];
$prec  = $_POST['prec']  ?? [];
$tot   = $_POST['tot']   ?? [];  // input hidden con el total por fila

$sqlDetalle = "INSERT INTO DETALLE (id_ct, deta, und, cant, prec, tot)
               VALUES (:id_ct, :deta, :und, :cant, :prec, :tot)";
$stmtDet = $pdo->prepare($sqlDetalle);

for ($i = 0; $i < count($deta); $i++) {
    // Verificamos que no haya undefined
    $val_deta = $deta[$i] ?? '';
    $val_und  = $und[$i]  ?? '';
    $val_cant = (float)($cant[$i] ?? 0);
    $val_prec = (float)($prec[$i] ?? 0);
    $val_tot  = (float)($tot[$i]  ?? 0);

    // Insertamos cada fila en DETALLE
    $stmtDet->execute([
        ':id_ct' => $id_ct,
        ':deta'  => $val_deta,
        ':und'   => $val_und,
        ':cant'  => $val_cant,
        ':prec'  => $val_prec,
        ':tot'   => $val_tot
    ]);
}

// 5. Calcular total_neto, iva, total (19%)
$total_neto = 0;
// Sumamos todos los tot de las filas
foreach ($tot as $filaTotal) {
    $total_neto += (float)$filaTotal;
}
$iva   = $total_neto * 0.19;
$total = $total_neto + $iva;

// 6. Insertar en TOTALES
$sqlTotales = "INSERT INTO TOTALES (id_ct, total_neto, iva, total)
               VALUES (:id_ct, :neto, :iva, :total)";
$stmtTot = $pdo->prepare($sqlTotales);
$stmtTot->execute([
    ':id_ct' => $id_ct,
    ':neto'  => $total_neto,
    ':iva'   => $iva,
    ':total' => $total
]);

// 7. Mensaje o redirección
echo "Cotización guardada exitosamente con ID $id_ct.<br>";
echo "Total Neto: $total_neto | IVA: $iva | Total: $total";

// O podrías redirigir a otra página:
// header("Location: ver_cotizacion.php?id_ct=$id_ct");
// exit;
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Cotización Generada</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin-top: 50px;
    }
    .btn-volver {
      background-color: #007bff; /* azul */
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }
    .btn-volver:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<h2>¡Cotización guardada exitosamente!</h2>
<p>ID Cotización: <strong><?php echo htmlspecialchars($id_ct); ?></strong></p>
<p>Total Neto: <strong><?php echo $total_neto; ?></strong></p>
<p>IVA (19%): <strong><?php echo $iva; ?></strong></p>
<p>Total: <strong><?php echo $total; ?></strong></p>

<!-- Botón para volver a tu formulario principal, por ejemplo "html.php" -->
<button class="btn-volver" onclick="window.location.href='html.php';">Volver</button>

</body>
</html>
<?php
// Fin de procesar.php
