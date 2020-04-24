<?php
$mysqli = new mysqli("127.0.0.1", "root", "GAdL*1917", "sudo_tracker");

if($mysqli->connect_error)
{
  exit('No se pudo conectar a la base');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli->set_charset("utf8mb4");
date_default_timezone_set("America/Mexico_City");
?>
