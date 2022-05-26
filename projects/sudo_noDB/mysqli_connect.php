<?php
// $mysqli = new mysqli("localhost", "tuusuario", "tucontraseña", "SUDO_TRACKER");
$mysqli = new mysqli("localhost", "root", "GAdL*49201917", "sudotracker");

if($mysqli->connect_error)
{
  exit('No se pudo conectar a la base');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli->set_charset("utf8mb4");
?>
