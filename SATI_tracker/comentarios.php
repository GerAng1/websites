<?php

// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require 'sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'M') {header("Location: mesa/mainmesa.php");}
  if (empty($_SESSION['rol'])) {header("Location: index.php");}

// Queries
  $stmt_proyectos = $mysqli->prepare(
    "SELECT PROYECTO_ID, Nombre, Fecha_inicio, Completado
    FROM sudo_tracker.proyecto;");
  $stmt_proyectos->execute();
  $proyectos = $stmt_proyectos->get_result();

?>

<!-- -- AQUI EL MIEMBRO SE COMUNICA CON EL ADMINISTRADOR -- -->
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>SATI Comentarios</title>
    <link rel="shortcut icon" href="assets/pics/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="index.php"><img src="assets/pics/logo_sati.png" height="30" alt="Logo SATI">  SATI Tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="blog/blog.php">Blog <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cuenta.php">Cuenta</a>
          </li>
          <li class="nav-item active">
                <a class="nav-link" href="comentarios.php">Comentarios</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="sec/logout.php">Cerrar Sesión</a>
            </li>
        </ul>
      </div>
      <a class="navbar text-right lead text-body" href="index.php">¡ Hola <?php echo $_SESSION['nombre']; ?> !</a>
    </nav>
    <!-- End of navbar -->

    <div class="jumbotron" style="background:url(assets/pics/bg_it.png); background-size: cover; background-repeat: no-repeat;">
      <div class="row">
        <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
          <h1 class="pb-2 display-4">Comentar Proyecto</h1>
          <hr class="my-2">
          <p class="pl-3 font-italic">¿Recomendaciones, dudas y/o problemas? Selecciona tu proyecto y escribe un comentario.</p>
          <!-- <h4 class="font-italic text-right bg-light text-dark mb-2"></h4> -->
        </div>
      </div>
    </div>

    <div class="container-fluid mx-2">
      <form class="" action="comentarios.php" method="POST">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Nombre Proyecto</th>
            <th scope="col">Fecha entrega</th>
            <th scope="col">Seleccionado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($proyecto = $proyectos->fetch_assoc())
          { ?>
            <tr>
              <th scope="row"><?php echo $proyecto['Nombre']; ?></th>
              <td><?php echo $proyecto['Fecha_inicio']; ?></td>
              <td>
                <div class="btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-info mb-1">
                  <input type="checkbox" name="toErase[]" value="<?php echo $proyecto['PROYECTO_ID']; ?>"> <?php echo $proyecto['Nombre']; ?>
                </label>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <hr class="mt-2 mb-4">
      </div> <!-- container1 -->

      <div class="container">
        <div class="row">
          <div class="col">
            <textarea class="form-control" aria-label="Comment" placeholder="Comentarios"></textarea>
          </div>
          <div class="col">
            <button class="btn btn-info btn-lg" type="submit" name="borrar">Comentar</button>
          </div>
        </div>
      </div>
    </form>

    <div class="row-fluid">
      <div class="text-center bg-dark mt-5">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link text-white" href="blog/contactos_sati.php">Reportar Errores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="https://getbootstrap.com/docs/4.2/getting-started/introduction/" target="_blank"
              rel="noopener noreferrer">Aprende Bootstrap</a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/Popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
