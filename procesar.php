<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos



// 2. Recoger datos de la tabla CT
$nom_ven = $_POST['nom_ven'] ?? '';
$fecha   = $_POST['fecha']   ?? '';
$correo  = $_POST['correo']  ?? '';
$cliente = $_POST['cliente'] ?? '';
$giro    = $_POST['giro']    ?? '';
$celular = $_POST['celular'] ?? '';
$contacto = $_POST['contacto'] ?? '';
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
$tot   = $_POST['tot']   ?? [];

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


$total_neto = 0;
// Sumamos todos los tot de las filas
foreach ($tot as $filaTotal) {
  $total_neto += (float)$filaTotal;
}
$iva   = $total_neto * 0.19;
$total = $total_neto + $iva;


$sqlTotales = "INSERT INTO TOTALES (id_ct, total_neto, iva, total)
               VALUES (:id_ct, :neto, :iva, :total)";
$stmtTot = $pdo->prepare($sqlTotales);
$stmtTot->execute([
  ':id_ct' => $id_ct,
  ':neto'  => $total_neto,
  ':iva'   => $iva,
  ':total' => $total
]);


header("Location: index.php?id_ct=" . $id_ct);
exit;

?>
