<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require '../sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'A') {header("Location: ../main.php");}
  if (empty($_SESSION['rol'])) {header("Location: ../index.php");}

// Queries
  $matricula = $_SESSION['matr'];

  $stmt_proyectos = $mysqli->prepare(
    "SELECT PROYECTO_ID, Nombre, Fecha_inicio, Completado
    FROM sudo_tracker.proyecto;");
  $stmt_proyectos->execute();
  $proyectos = $stmt_proyectos->get_result();

  $stmt_datos = $mysqli->prepare(
    "SELECT Contrasena FROM sudo_tracker.usuario
    WHERE MATRICULA = '$matricula';");
  $stmt_datos->execute();
  $row_datos = $stmt_datos->get_result()->fetch_assoc();

  $stmt_remocion_participantes = $mysqli->prepare(
    "DELETE FROM `sudo_tracker`.`usuario_tiene_proyecto`
    WHERE `PROYECTO_ID` = ?;");
  $stmt_remocion_participantes->bind_param("i", $to_erase);

  $stmt_remocion_responsable = $mysqli->prepare(
    "DELETE FROM `sudo_tracker`.`responsable_proyecto`
    WHERE `PROYECTO_ID` = ?;");
  $stmt_remocion_responsable->bind_param("i", $to_erase);

  $stmt_remocion_proyecto = $mysqli->prepare(
    "DELETE FROM `proyecto`
    WHERE `PROYECTO_ID` = ?;");
  $stmt_remocion_proyecto->bind_param("i", $to_erase);

// Funcion para quitar proyectos
  if (isset($_POST['borrar']) && password_verify($_POST['verif'], $row_datos['Contrasena']))
  {
    if(!empty($_POST['toErase']))
    {
      foreach ($_POST['toErase'] as $to_erase)
      {
        $stmt_remocion_participantes->execute();
        $stmt_remocion_responsable->execute();
        $stmt_remocion_proyecto->execute();
      }
      $_SESSION['mensaje'] = "¡Éxito!";
      $stmt_remocion_participantes->close();
      $stmt_remocion_responsable->close();
      $stmt_remocion_proyecto->close();
      header("Location: deleteproyectos.php");
    }
    else { $_SESSION['mensaje'] = "¡No se seleccionó proyecto!"; }
  }
  elseif (isset($_POST['borrar']) && !password_verify($_POST['verif'], $row_datos['Contrasena']))
  {
    $_SESSION['mensaje'] = "¡Contraseña incorrecta!";
  }
  else {$_SESSION['mensaje'] = "Una vez eliminados, ¡no se pueden recuperar!";}
?>

<!-- -- AQUI EL ADMINISTRADOR QUITA PROYECTOS -- -->
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <title>SATI Eliminar Proyectos</title>
    <link rel="shortcut icon" href="../assets/pics/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="../index.php"><img src="../assets/pics/logo_sati.png" height="30" alt="Logo SATI">  SATI Tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="../blog/blog.php">Blog <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../cuenta.php">Cuenta</a>
          </li>
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Gestión Proyectos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="addproyectos.php">Agregar otro proyecto</a>
              <a class="dropdown-item" href="deleteproyectos.php">Eliminar proyecto</a>
              <a class="dropdown-item" href="comentariosmesa.php">Comentarios proyectos</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../sec/logout.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
      <a class="navbar text-right lead text-body" href="../index.php">¡ Hola <?php echo $_SESSION['nombre']; ?> !</a>
    </nav>
    <!-- End of navbar -->

    <div class="jumbotron" style="background:url(../assets/pics/bg_it.png); background-size: cover; background-repeat: no-repeat;">
      <div class="row">
        <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
          <h1 class="pb-2 display-4">Eliminar Proyectos</h1>
          <p class="pl-3 font-italic">Selecciona los proyectos que desea eliminar.</p>
          <hr class="my-2">
          <h4 class="font-italic text-right bg-light text-dark mb-2"><?php echo $_SESSION['mensaje']; ?></h4>
        </div>
      </div>
    </div>

    <div class="container-fluid mx-2">
      <form class="" action="deleteproyectos.php" method="POST">
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

      <div class="container d-flex justify-content-end">
        <div class="row ">
          <div class="col mx-auto">
            <input class="form-control form-control-lg" type="password" id="verif" name="verif" placeholder="Contraseña" required>
          </div>
          <div class="col mx-auto">
            <button class="btn btn-dark btn-lg" type="submit" name="borrar">BORRAR</button>
          </div>
        </div>
      </div>
    </form>

    <div class="row-fluid">
      <div class="text-center bg-dark mt-5">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link text-white" href="../blog/contactos_sati.php">Reportar Errores</a>
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
    <script src="../assets/js/jQuery.js"></script>
    <script src="../assets/js/Popper.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>
