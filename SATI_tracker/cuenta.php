<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require 'sec/mysqli_connect.php';

// Redirecciones
  if (empty($_SESSION['rol'])) {header("Location: index.php");}

// Queries
  $matricula = $_SESSION['matr'];

  $stmt_datos = $mysqli->prepare(
    "SELECT Contrasena
    FROM sudo_tracker.usuario
    WHERE MATRICULA = '$matricula';");
  $stmt_datos->execute();
  $row_datos = $stmt_datos->get_result()->fetch_assoc();

  // Solo si queremos agregar la opcion de mail y telefono
  // (las combinaciones incrementan, más codigo)
  // $stmt_actualizacion_usuario = $mysqli->prepare("UPDATE `sudo_tracker`.`usuario` SET Alias = ?, Contrasena = ?, Telefono = ?, Mail = ? WHERE MATRICULA = '$matricula';");
  // $stmt_actualizacion_usuario->bind_param("ssss", $alias, $hashed, $tel, $mail);

  $stmt_actualizacion_usuario = $mysqli->prepare(
    "UPDATE `sudo_tracker`.`usuario`
    SET Alias = ?, Contrasena = ?
    WHERE MATRICULA = '$matricula';");
  $stmt_actualizacion_usuario->bind_param("ss", $alias, $hashed);

// Funcion para cambiar contraseña y alias
  if(($_POST['nuevoAlias'] !== "") && ($_POST['currentPW'] !== "")
    && ($_POST['new_pw'] !== "") && (isset($_POST['setnewstuff'])))
  {
    $current_pw = $_POST['currentPW'];

    if(password_verify($current_pw, $row_datos['Contrasena']))
    {
      $alias = $_POST['nuevoAlias'];
      $new_pw = $_POST['new_pw'];
      $hashed = set_password($new_pw);
      $_SESSION['nombre'] = $alias;
      $_SESSION['mensaje'] = "¡Alias y contraseña cambiada!";
      $stmt_actualizacion_usuario->execute();
    }
    else
    { $_SESSION['mensaje'] = "La contraseña fue incorrecta"; }
  }

  elseif(($_POST['nuevoAlias'] !== "") && ($_POST['currentPW'] !== "")
    && ($_POST['new_pw'] == "") && (isset($_POST['setnewstuff'])))
  {
    $current_pw = $_POST['currentPW'];

    if(password_verify($current_pw, $row_datos['Contrasena']))
    {
      $alias = $_POST['nuevoAlias'];
      $new_pw = $current_pw;
      $hashed = set_password($new_pw);
      $_SESSION['nombre'] = $alias;
      $_SESSION['mensaje'] = "¡Alias cambiada!";
      $stmt_actualizacion_usuario->execute();
    }
    else
    { $_SESSION['mensaje'] = "La contraseña fue incorrecta"; }
  }

  elseif(($_POST['nuevoAlias'] == "") && ($_POST['currentPW'] !== "")
    && ($_POST['new_pw'] !== "") && (isset($_POST['setnewstuff'])))
  {
    $current_pw = $_POST['currentPW'];

    if(password_verify($current_pw, $row_datos['Contrasena']))
    {
      $alias = $_SESSION['nombre'];
      $new_pw = $_POST['new_pw'];
      $hashed = set_password($new_pw);
      $_SESSION['mensaje'] = "Contraseña cambiada!";
      $stmt_actualizacion_usuario->execute();
    }
    else
    { $_SESSION['mensaje'] = "La contraseña fue incorrecta"; }
  }

  else
  {
    $_SESSION['mensaje'] = "Se requiere de contraseña actual para hacer cambios.";
  }

  // Funcion hasheo
  function set_password($tohash)
  {
    $hashed = password_hash($tohash, PASSWORD_DEFAULT);
    return $hashed;
  }
?>

<!-- -- Página para editar alias y contraseña de todo usuario -- -->
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>SATI Settings</title>
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
          <li class="nav-item active">
            <a class="nav-link" href="cuenta.php">Cuenta</a>
          </li>
          <li class="nav-item">
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

    <div class="jumbotron" style="background:url(assets/pics/bg_it.png) no-repeat; background-size: cover;">
      <div class="row px-4">
        <div class="col-lg-4">
          <div class="p-2 my-5 bg-secondary text-white text-left rounded">
            <h1 class="display-4 ml-3">Modificar Cuenta</h1>
            <p class="font-italic ml-4">¡Puedes cambiar contraseña y tu alias para que te ubiquemos mejor!</p>
            <hr class="my-2">
            <h4 class="font-italic text-right mb-2 bg-light text-dark"><?php echo $_SESSION['mensaje']; ?></h4>
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
            <input type="text" class="form-control" name="nuevoAlias" value="" aria-describedby="Alias" placeholder="Tu nuevo Alias (Opcional)">
          </div>
        </div>
      </div>
      <!-- <div class="row" id="new_mail">
        <div class="col-6">
          <div class="form-group">
            <label for="nuevoMail">¿Quieres agregar un correo electrónico?</label>
            <input type="text" class="form-control" id="nuevoMail" name="nuevoMail" value="" placeholder="e-Mail (Opcional)">
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="nuevoTel">Agrega/actualiza tu número de celular</label>
            <input type="password" class="form-control" id="new_tel" name="new_tel" value="" placeholder="10 dígitos sin espacios (Opcional)">
          </div>
        </div>
      </div> -->
      <div class="row" id="new_pw">
        <div class="col-6">
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña actual</label>
            <input type="password" class="form-control" name="currentPW" value="" placeholder="Contraseña (Obligatorio)">
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="exampleInputPassword1">Nueva contraseña</label>
            <input type="password" class="form-control" name="new_pw" value="" placeholder="Sólo si vas a cambiar contraseña">
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
