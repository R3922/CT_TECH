<?php
// conexion.php

$host    = 'localhost';
$db      = 'nombre_base_datos'; // Reemplaza con el nombre de tu base de datos
$user    = 'usuario';           // Reemplaza con tu usuario de la BD
$pass    = 'contraseña';        // Reemplaza con tu contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Activa excepciones en caso de error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Obtiene los resultados como array asociativo
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // En producción, se recomienda un manejo más discreto de errores
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
