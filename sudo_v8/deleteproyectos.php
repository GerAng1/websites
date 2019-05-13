<?php
session_start();
require 'mysqli_connect.php';

// Redireccionamiento
if($_SESSION['Tipo_usuario'] == "u"){header("Location: main.php");}
if(empty($_SESSION['matricula'])){header("Location: index.php");}

if (isset($_POST['borrar']) && $_POST['verif'] == $_SESSION['password'])
{
  $stmt_remocion_participantes = $mysqli->prepare("DELETE FROM USUARIO_REPORTA_PROYECTO WHERE Num_proyecto=?;");
  $stmt_remocion_mesa_crea = $mysqli->prepare("DELETE FROM MESA_CREA_PROYECTOS WHERE Num_proyecto=?;");
  $stmt_remocion = $mysqli->prepare("DELETE FROM SUDO_TRACKER.PROYECTOS WHERE Num_proyecto = ?;");

  if(!empty($_POST['toErase']))
  {
    $_SESSION['messages'] = "¡Éxito!";
    foreach ($_POST['toErase'] as $this_garbage) {
      $stmt_remocion_participantes->bind_param("s", $this_garbage);
      $stmt_remocion_participantes->execute();

      $stmt_remocion_mesa_crea->bind_param("s", $this_garbage);
      $stmt_remocion_mesa_crea->execute();

      $stmt_remocion->bind_param("s", $this_garbage);
      $stmt_remocion->execute();
    }
  }
  else {
    $_SESSION['messages'] = "¡No se seleccionó proyecto!";
  }
}

elseif (isset($_POST['borrar']) && $_POST['verif'] != $_SESSION['password'])
{
  $_SESSION['messages'] = "¡Contraseña incorrecta!";
}
else {$_SESSION['messages'] = "Una vez eliminados, ¡no se pueden recuperar!";}

$stmt_proyectos = $mysqli->prepare("SELECT Num_proyecto, Nom_proy, Fecha_hora_entrega FROM PROYECTOS;");
$stmt_proyectos->execute();
$proyectos = $stmt_proyectos->get_result();

?>
<!-- AQUIE EL ADMINISTRADOR QUITA PROYECTOS -->
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>SUDO Eliminar Proyectos</title>
    <link rel="shortcut icon" href="assets/pics/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="index.php"><img src="assets/pics/logo_sudo.png" height="30" alt="Logo SUDO">  SUDO Tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="sudo_blog.php">Blog <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cuenta.php">Cuenta</a>
          </li>
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Gestión Proyectos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="proyectosmesa.php">Agregar otro proyecto</a>
              <a class="dropdown-item" href="deleteproyectos.php">Eliminar proyecto</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
      <a class="navbar text-right lead text-body" href="index.php">¡ Hola <?php echo $_SESSION['Nombre']; ?> !</a>
    </nav>
    <!-- End of navbar -->

    <div class="jumbotron" style="background:url(assets/pics/bg_it.png); background-size: cover; background-repeat: no-repeat;">
      <div class="row">
        <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
          <h1 class="pb-2 display-4">Eliminar Proyectos</h1>
          <p class="pl-3 font-italic">Selecciona los proyectos que desea eliminar.</p>
          <hr class="my-2">
          <h4 class="font-italic text-right mb-2"><?php echo $_SESSION['messages']; ?></h4>
        </div>
      </div>
    </div>

    <div class="container mx-5">
      <form class="" method="post">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Nombre Proyecto</th>
            <th scope="col">Fecha entrega</th>
            <th scope="col">Seleccionado</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($proyecto = $proyectos->fetch_assoc())
          { ?>
            <tr>
              <th scope="row"><?php echo $proyecto['Nom_proy']; ?></th>
              <td><?php echo $proyecto['Fecha_hora_entrega']; ?></td>
              <td>
                <div class="btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-info mb-1">
                  <input type="checkbox" name="toErase[]" value="<?php echo $proyecto['Num_proyecto']; ?>"> <?php echo $proyecto['Nom_proy']; ?>
                </label>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <hr class="mt-2 mb-4">

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
    </div> <!-- container1 -->

    <div class="row-fluid">
      <div class="text-center bg-dark mt-5">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link text-white" href="contactos_sudo.php">Reportar Errores</a>
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
