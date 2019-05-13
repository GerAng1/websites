<?php
session_start();
require 'mysqli_connect.php';

// Redireccionamiento
if($_SESSION['Tipo_usuario'] == "u"){header("Location: main.php");}
if(empty($_SESSION['matricula'])){header("Location: index.php");}

$stmt_usuarios = $mysqli->prepare("SELECT ID_usuario, Nombre FROM USUARIO WHERE Tipo_usuario='u';");
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

$matricula = $_SESSION['matricula'];

$stmt_creacion_proy = $mysqli->prepare("INSERT INTO PROYECTOS (Nom_proy, Descripcion, Fecha_hora_entrega) VALUES (?, ?, ?);");
$stmt_admin_crea_proy = $mysqli->prepare("INSERT INTO MESA_CREA_PROYECTOS (ID_Mesa_dir, Num_proyecto) VALUES ('$matricula', ?);");
$stmt_fetch_num_proy = $mysqli->prepare("SELECT Num_proyecto FROM PROYECTOS WHERE Nom_proy=?;");
$stmt_agregar_participantes = $mysqli->prepare("INSERT INTO USUARIO_REPORTA_PROYECTO (ID_usuario, Num_proyecto, Completado) VALUES (?, ?, 0);");


if(isset($_POST['add']))
{
  if(!empty($_POST['listaPart']))
  {
    $listaPart = array();
    foreach($_POST['listaPart'] as $participantes)
    {
      array_push($listaPart, $participantes);
    }
  }

  $year = substr($_POST['Fecha_hora_entrega'], 0,4);
  $month = substr($_POST['Fecha_hora_entrega'], 5,7);
  $day = substr($_POST['Fecha_hora_entrega'], 8,10);

  if (strlen($_POST['nombre_proyecto']) <= 45 && strlen($_POST['descripcion_proyecto']) <= 255 && checkdate($month, $day, $year))
  {
    $_SESSION['messages'] = "¡Proyecto agregado correctamente!";
    $stmt_creacion_proy->bind_param("sss", $_POST['nombre_proyecto'], $_POST['descripcion_proyecto'], $_POST['Fecha_hora_entrega']);
    $stmt_creacion_proy->execute();

    $stmt_fetch_num_proy->bind_param("s", $_POST['nombre_proyecto']);
    $stmt_fetch_num_proy->execute();
    $num = $stmt_fetch_num_proy->get_result();
    $nu = $num->fetch_assoc();

    $stmt_admin_crea_proy->bind_param("s", $nu['Num_proyecto']);
    $stmt_admin_crea_proy->execute();

    foreach ($listaPart as $participante)
    {
      $stmt_agregar_participantes->bind_param("si", $participante, $nu['Num_proyecto']);
      $stmt_agregar_participantes->execute();
    }
  }
  else {$_SESSION['messages'] = "Favor de ingresar correctamente los datos";}
}
else {$_SESSION['messages'] = "¡Asegérate de llenar todos los campos!";}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>SUDO Proyectos</title>
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
          <h1 class="pb-2 display-4">Agregar Proyectos</h1>
          <p class="pl-3 font-italic">Agrega nuevos proyectos aquí.</p>
          <hr class="my-2">
          <h4 class="font-italic text-right mb-2"><?php echo $_SESSION['messages']; ?></h4>
            </p>
        </div>
      </div>
    </div>

    <div class="container mx-auto">
      <form class="" method="post">
        <div class="form-row d-flex justify-content-between ">
          <div class="col-auto mb-3">
            <label>Nombre Proyecto</label>
            <input type="text" class="form-control" name="nombre_proyecto" placeholder="Nombre Proyecto" value="" required>
          </div>
          <div class="col-auto mb-3">
            <label>Fecha y hora de proyecto</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupPrepend">aaaa-mm-dd</span>
              </div>
              <input type="text" class="form-control" id="Fecha_hora_entrega" value="" name="Fecha_hora_entrega" placeholder="Fecha" aria-describedby="inputGroupPrepend" required>
            </div>
          </div>
        </div>
        <div class="form-row d-flex justify-content-around">
          <div class="col-12 mb-3">
            <label>Descripción</label>
            <textarea class="form-control" id="descripcion_proyecto" name="descripcion_proyecto" value="" placeholder="Descripción Proyecto" required></textarea>
          </div>
        </div>
        <div class="form-row d-flex justify-content-around">
          <label>Participantes</label>
            <div class="col-12 mb-3 btn-group-toggle" data-toggle="buttons">
              <?php while ($usuario = $usuarios->fetch_assoc())
              { ?>
                <label class="btn btn-info mb-1">
                  <input type="checkbox" name="listaPart[]" value="<?php echo $usuario['ID_usuario']; ?>"> <?php echo $usuario['Nombre']; ?>
                </label>
              <?php } ?>
          </div>
        </div>
        <div class="row d-flex justify-content-end">
          <button class="btn btn-dark" type="submit" name="add">Agregar</button>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
