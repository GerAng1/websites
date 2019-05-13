<?php
session_start();

require 'mysqli_connect.php';

// ---------------------------STATEMENTS--------------------------------------

$stmt_verificacion = $mysqli->prepare("SELECT Nombre, Contrasena, Tipo_usuario FROM USUARIO
  WHERE ID_usuario=? AND Contrasena=?;");


  // mini espacio para que reanude sesion si se sale
  if((isset($_SESSION['matricula'])))
  {
    $stmt_verificacion->bind_param('ss', $_SESSION['matricula'], $_SESSION['password']);
    $stmt_verificacion->execute();
    $verif = $stmt_verificacion->get_result();
    $row = $verif->fetch_assoc();
    if ($verif->num_rows == 1)
    {
      if ($row['Tipo_usuario']=='a')
      {
        header("Location: mainmesa.php");
      }
      else
      {
        header("Location: main.php");
      }
    }
  }

if(isset($_POST['submit']))
{
  if (func($stmt_verificacion) == 1)
  {
    header("Location: mainmesa.php");
  }
  elseif (func($stmt_verificacion) == 2)
  {
    header("Location: main.php");
  } else
  {
    header("Location: indexerror.php");
  }
}

function func($stmt_verificacion)
{
  if(isset($_POST['correo_e']) && isset($_POST['pw']))
  {
    $mail = $_POST['correo_e'];
    $_SESSION['type_error'] = "Contraseña Inválida.";

    if (strlen($mail) > 18 || strlen($mail) < 9 || (strlen($mail) > 9 && strlen($mail) < 18))
    {
      $_SESSION['type_error'] = "La sintáxis del correo no es válida.";
      return 3;
    }

    elseif (strlen($mail) == 18 && (substr($mail, 9, 19) == "@itesm.mx"))
    {
      $matricula = strtoupper(substr($mail, 0,9));
      $pw = $_POST['pw'];
      $stmt_verificacion->bind_param('ss', $matricula, $pw);
      $stmt_verificacion->execute();
      $verif = $stmt_verificacion->get_result();

      if ($verif->num_rows == 1)
      {
        $_SESSION['matricula'] = $matricula;
        $_SESSION['password'] = $pw;
        $row = $verif->fetch_assoc();
        $_SESSION['Tipo_usuario'] = $row['Tipo_usuario'];
        return ($_SESSION['Tipo_usuario'] == 'a') ? 1 : 2 ;
      }
      else
      {
        $_SESSION['type_error'] = "Usuario o contraseña están mal.";
        return 3;
      }
    }
    elseif (strlen($mail) == 18 && (substr($mail, 9, 19) != "@itesm.mx"))
    {
      $_SESSION['type_error'] = "Dominio no corresponde a base de datos.";
      return 3;
    }

    else
    {
      $matricula = strtoupper($mail);
      $pw = $_POST['pw'];
      $stmt_verificacion->bind_param('ss', $matricula, $pw);
      $stmt_verificacion->execute();
      $verif = $stmt_verificacion->get_result();

      if ($verif->num_rows == 1)
      {
        $_SESSION['matricula'] = $matricula;
        $_SESSION['password'] = $pw;
        $row = $verif->fetch_assoc();
        $_SESSION['Tipo_usuario'] = $row['Tipo_usuario'];
        return ($_SESSION['Tipo_usuario'] == 'a') ? 1 : 2 ;
      }

      else
      {
        $_SESSION['type_error'] = "Usuario o contraseña están mal.";
        return 3;
      }
    }
  }
  else
  {
    $_SESSION['type_error'] = "Error desconocido.";
    return 3;
  }
}
?>

<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>Login SUDO</title>
    <link rel="shortcut icon" href="assets/pics/favicon.ico" type="image/x-icon">

  </head>
  <body style="background-image: url(assets/pics/bg_it.png); background-size: cover; background-repeat: no-repeat;">
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
        </ul>
      </div>
      <a class="navbar text-right lead text-body" href="index.php">¡ Bienvenid@ !</a>
    </nav>
    <!-- End of navbar -->

    <div class="container py-5">
      <div class="row pt-5 text-light">
        <div class="col pt-5">
          <div class="card bg-transparent" style="width: 18rem;">
            <img src="assets/pics/logo_sudo.png" class="card-img-top" alt="Logo SUDO">
            <div class="card-body">
              <h2 class="card-text text-light text-center">SUDO Login</h2>
            </div>
          </div>
        </div>
        <div class="col"></div>
        <div class="col pt-5">
          <form class="" method="POST">
            <div class="form-group">
              <label for="correo_e">Matrícula</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="A00705441" id="correo_e" name="correo_e" aria-label="Matrícula" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">@itesm.mx</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="pase_entrada">Contraseña</label>
              <input type="password" class="form-control" name="pw" id="pase_entrada" required="" placeholder="1234">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Iniciar Sesión"></input>
          </form>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-light" href="contactos_sudo.php">¿Olvidó Contraseña?</a>
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
