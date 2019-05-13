<?php
session_start();
require 'mysqli_connect.php';

// Redireccionamiento
if(empty($_SESSION['matricula'])){header("Location: index.php");}

$matricula = $_SESSION['matricula'];
$stmt_actualizacion_usuario = $mysqli->prepare("UPDATE USUARIO
  SET Nombre = ?, Contrasena = ? WHERE ID_usuario='$matricula';");

if(($_POST['nuevoAlias'] !== "") && ($_POST['currentPW'] !== "")
  && ($_POST['new_pw'] !== "") && (isset($_POST['setnewstuff'])))
{
  $alias = $_POST['nuevoAlias'];
  $current_pw = $_POST['currentPW'];
  $new_pw = $_POST['new_pw'];

  if($current_pw == $_SESSION['password'])
  {
    $stmt_actualizacion_usuario->bind_param("ss", $alias, $new_pw);
    $stmt_actualizacion_usuario->execute();
    $_SESSION['Nombre'] = $alias;
    $_SESSION['password'] = $new_pw;
    $_SESSION['messages'] = "¡Alias y contraseña cambiada!";
  }
  else
  {
    $_SESSION['messages'] = "La contraseña fue incorrecta";
  }
}

elseif(($_POST['nuevoAlias'] !== "") && ($_POST['currentPW'] !== "")
  && ($_POST['new_pw'] == "") && (isset($_POST['setnewstuff'])))
{
  $alias = $_POST['nuevoAlias'];
  $current_pw = $_POST['currentPW'];
  $new_pw = $current_pw;

  if($current_pw == $_SESSION['password'])
  {
    $stmt_actualizacion_usuario->bind_param("ss", $alias, $new_pw);
    $stmt_actualizacion_usuario->execute();
    $_SESSION['Nombre'] = $alias;
    $_SESSION['messages'] = "¡Alias cambiada!";
  }
  else
  {
    $_SESSION['messages'] = "La contraseña fue incorrecta";
  }
}

elseif(($_POST['nuevoAlias'] == "") && ($_POST['currentPW'] !== "")
  && ($_POST['new_pw'] !== "") && (isset($_POST['setnewstuff'])))
{
  $alias = $_SESSION['Nombre'];
  $current_pw = $_POST['currentPW'];
  $new_pw = $_POST['new_pw'];

  if($current_pw == $_SESSION['password'])
  {
    $stmt_actualizacion_usuario->bind_param("ss", $alias, $new_pw);
    $stmt_actualizacion_usuario->execute();
    $_SESSION['password'] = $new_pw;
    $_SESSION['messages'] = "Contraseña cambiada!";
  }
  else
  {
    $_SESSION['messages'] = "La contraseña fue incorrecta";
  }
}

else
{
  $_SESSION['messages'] = "Se requiere de contraseña actual para hacer cambios.";
}

?>

<!-- ESTE EL LA PAGINA CUENTA MESA -->
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>SUDO Settings</title>
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
          <li class="nav-item active">
            <a class="nav-link" href="cuenta.php">Cuenta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
      <a class="navbar text-right lead text-body" href="index.php">¡ Hola <?php echo $_SESSION['Nombre']; ?> !</a>
    </nav>
    <!-- End of navbar -->

    <div class="jumbotron" style="background:url(assets/pics/bg_it.png) no-repeat; background-size: cover;">
      <div class="row px-4">
        <div class="col-lg-4">
          <div class="p-2 my-5 bg-secondary text-white text-left rounded">
            <h1 class="display-4 ml-3">Modificar Cuenta</h1>
            <p class="font-italic ml-4">¡Puedes cambiar contraseña y tu alias para que te digamos como te gusta!</p>
            <hr class="my-2">
            <h4 class="font-italic text-right mb-2"><?php echo $_SESSION['messages']; ?></h4>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <form class="" method="POST">
      <div class="row" id="new_name">
        <div class="col">
          <div class="form-group">
            <label for="nuevoAlias">¿Cómo quieres que te digamos?</label>
            <input type="text" class="form-control" name="nuevoAlias" id="nuevoAlias" value="" aria-describedby="Alias" placeholder="Tu nuevo Alias">
          </div>
        </div>
      </div>
      <div class="row" id="new_pw">
        <div class="col-6">
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña actual</label>
            <input type="password" class="form-control" id="currentPW" name="currentPW" value="" placeholder="Contraseña">
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="exampleInputPassword1">Nueva contraseña</label>
            <input type="password" class="form-control" id="new_pw" name="new_pw" value="" placeholder="Contraseña">
          </div>
        </div>
      </div>
      <button type="submit" name="setnewstuff" class="btn btn-info">Enviar</button>
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
