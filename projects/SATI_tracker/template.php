<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require 'sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'M') {header("Location: mainmesa.php");}
  if (empty($_SESSION['rol'])) {header("Location: index.php");}

// Queries

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" href="assets/pics/favicon.ico" type="image/x-icon">

    <title>Hello, world!</title>
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light page-scroll">
      <a class="navbar-brand" href="blog.html"><img src="assets/pics/logo_sati.png" height="30" alt="Logo SATI"> SATI News</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Noticias <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a href="#quienes" class="nav-link" data-toggle="modal" data-target="#exampleModalCenter">Quienes somos</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Eventos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="pasados.php">Pasados</a>
              <a class="dropdown-item" href="#">Próximos</a>
              <a class="dropdown-item" href="#">Galería</a>
            </div>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="navbar text-right lead text-body" href="index.php">¡ Iniciar Sesión !</a>
      </li>
      </ul>
    </nav>
    <!-- End of navbar -->
    <div class="container-fluid">
      <div class="row">
        <h1>Hello, world!</h1>
      </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/Popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
