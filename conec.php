<?php

require 'headers.php';

$host_db = "localhost";
$user_table="";
$user_db = "jean";
$user_password = "";

$conn = mysqli_connect($host_db,  $user_db, $user_password, $uset_table);

if (!$conn) {
    //  echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    //  echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    //  echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    httpCode(401, "No se pudo conectar a MySQL.");
    exit;
}
?>
