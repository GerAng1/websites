<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require 'sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'M') {header("Location: mesa/mainmesa.php");}
  if ($_SESSION['rol'] == 'A') {header("Location: main.php");}

  if(isset($_POST['submit']))
  {
    if (check_data($mysqli)==1)
      {header("Location: mesa/mainmesa.php");}
    elseif (check_data($mysqli)==2)
      {header("Location: main.php");}
    else
      {header("Location: indexerror.php");}
  }

// Funcion para verificar tipo usuario y login
  function check_data($mysqli)
  {
    if(isset($_POST['matr']) && isset($_POST['pw']))
    {
      $stmt_tabla_usuario = $mysqli->prepare(
        "SELECT
        Contrasena, Nombre, Rol, Alias
        FROM usuario
        WHERE matricula = ? ;");
      $stmt_tabla_usuario->bind_param('s', $matricula);
      $mail = $_POST['matr'];
      $_SESSION['fail_login_type'] = "Contraseña o Usuario inválidos.";

      if ((strlen($mail) == 18 && (substr($mail, 9, 19) == "@itesm.mx")) || (strlen($mail) == 9))
      {
        $matricula = strtoupper(substr($mail, 0,9));
        $contrasena = $_POST['pw'];
        $stmt_tabla_usuario->execute();
        $row_usuario = $stmt_tabla_usuario->get_result()->fetch_assoc();

        if (password_verify($contrasena, $row_usuario['Contrasena']))
        {
          $_SESSION['matr'] = $matricula;
          $_SESSION['rol'] = $row_usuario['Rol'];
          if (isset($row_usuario['Alias'])) {
            $_SESSION['nombre'] = $row_usuario['Alias'];
          }
          else { $_SESSION['nombre'] = $row_usuario['Nombre']; }

          $stmt_tabla_usuario->close();
          return ($_SESSION['rol'] == 'M') ? 1 : 2 ;
        }
        else
        {
          $stmt_tabla_usuario->close();
          $_SESSION['fail_login_type'] = "Usuario o Contraseña están mal.";
          return 4;
        }
      }
      else
      {
        $stmt_tabla_usuario->close();
        $_SESSION['fail_login_type'] = "Usuario está mal.";
        return 4;
      }
    }
    else
    {
      $stmt_tabla_usuario->close();
      $_SESSION['fail_login_type'] = "Hidden Easter Egg! Esto no debería pasar nunca.";
      return 4;
    }
  }
?>

<!-- -- Pagina de inicio de sesion -- -->
<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>Login SATI</title>
    <link rel="shortcut icon" href="assets/pics/favicon.ico" type="image/x-icon">

    <body style="background-image: url(assets/pics/bg_it.png); background-size: cover; background-repeat: no-repeat;">
    <title>Inicia Sesion</title>
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="index.php"><img src="assets/pics/logo_sati.png" height="30" alt="Logo SATI"> SATI</a>
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
              <a class="nav-link" href="blog/contactos_sati.php">Contactos</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">Eventos</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="blog/futuros.php">Futuros</a>
                <a class="dropdown-item" href="blog/pasados.php">Pasados</a>
              </div>
            </li>
        </ul>
      </div>
      <a class="navbar text-right lead text-body active" href="index.php">¡Iniciar Sesión!</a>
    </nav>
    <!-- End of navbar -->

    <div class="container py-5">
      <div class="row pt-5 text-light">
        <div class="col pt-5">
          <div class="card bg-transparent" style="width: 18rem;">
            <img src="assets/pics/logo_sati.png" class="card-img-top" alt="Logo SATI">
            <div class="card-body">
              <h2 class="card-text text-light text-center">SATI Login</h2>
            </div>
          </div>
        </div>
        <div class="col"></div>
        <div class="col pt-5">
          <form class="" action="index.php" method="POST">
            <div class="form-group">
              <label for="matr">Matrícula</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="A01023456" id="matr" name="matr" aria-label="Matrícula" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">@itesm.mx</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="pase_entrada">Contraseña</label>
              <input type="password" class="form-control" name="pw" id="pase_entrada" required="" placeholder="Contraseña">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Iniciar Sesión"></input>
          </form>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-light" href="blog/contactos_sati.php">¿Olvidó Contraseña?</a>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/Popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
