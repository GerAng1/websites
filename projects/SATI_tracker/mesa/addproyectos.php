<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require '../sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'A') {header("Location: ../main.php");}
  if (empty($_SESSION['rol'])) {header("Location: ../index.php");}

// Variables
  $_SESSION['mensaje'] = "Agrega nuevos proyectos aquí.";

// Queries
  $stmt_tablaresponsables = $mysqli->prepare(
    "SELECT MATRICULA, Nombre, Alias, Apellido
    FROM sudo_tracker.usuario
    WHERE Rol = 'M';");
  $stmt_tablaresponsables->execute();
  $result_tablaresponsables = $stmt_tablaresponsables->get_result();

  $stmt_tablaparticipantes = $mysqli->prepare(
    "SELECT MATRICULA, Nombre, Alias, Apellido
    FROM sudo_tracker.usuario
    WHERE Rol = 'A';");
  $stmt_tablaparticipantes->execute();
  $result_tablaparticipantes = $stmt_tablaparticipantes->get_result();

  $stmt_crearproy = $mysqli->prepare(
    "INSERT INTO `sudo_tracker`.`proyecto` (`Nombre`, `Descripcion`, `Fecha_inicio`, `Liga`)
    VALUES (?,?,?,?);");
  $stmt_crearproy->bind_param("ssss", $_POST[nombrproy], $_POST[descrproy], $_POST[fechaproy], $_POST[ligaproy]);

  $stmt_getproyectoID = $mysqli->prepare(
    "SELECT PROYECTO_ID
    FROM sudo_tracker.proyecto
    WHERE Nombre = ?;");
  // Si dos proyectos se llaman igual, tendremos problemas.
  $stmt_getproyectoID->bind_param("s", $nombrproy);

  $stmt_addmesa = $mysqli->prepare(
    "INSERT INTO `sudo_tracker`.`responsable_proyecto` (`MATRICULA`, `PROYECTO_ID`)
    VALUES (?,?);");
  $stmt_addmesa->bind_param("si", $mesa, $proyID);

  $stmt_addpart = $mysqli->prepare(
    "INSERT INTO `sudo_tracker`.`usuario_tiene_proyecto` (`MATRICULA`, `PROYECTO_ID`)
    VALUES (?,?);");
  $stmt_addpart->bind_param("si", $part, $proyID);

// Funcion para agregar proyectos
  if (isset($_POST['add']))
  {
    $year = substr($_POST['fechaproy'], 0, 4);
    $month = substr($_POST['fechaproy'], 5, 7);
    $day = substr($_POST['fechaproy'], 8, 10);

    if (strlen($_POST['nombrproy']) <= 45 && checkdate($month, $day, $year))
    {
      $nombrproy = $_POST['nombrproy'];
      $stmt_crearproy->execute();
      $stmt_getproyectoID->execute();
      $num = $stmt_getproyectoID->get_result()->fetch_assoc();
      $proyID = $num['PROYECTO_ID'];

      if (!empty($_POST['listaMesa']))
      {
        foreach ($_POST['listaMesa'] as $mesa)
        {
           $stmt_addmesa->execute();
        }
       }

      if (!empty($_POST['listaPart']))
      {
        foreach ($_POST['listaPart'] as $part)
        {
           $stmt_addpart->execute();
        }
       }
      $_SESSION['mensaje'] = "¡Proyecto agregado exitosamente!";
    }
    else {$_SESSION['mensaje'] = "Favor de ingresar correctamente los datos";}
  }
  else {$_SESSION['mensaje'] = "¡Asegúrate de llenar todos los campos!";}
?>

<!-- -- AQUI EL ADMINISTRADOR AGREGA PROYECTOS -- -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <title>SATI Proyectos</title>
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
          <h1 class="pb-2 display-4">Agregar Proyectos</h1>
          <p class="pl-3 font-italic">Agrega nuevos proyectos aquí.</p>
          <hr class="my-2">
          <h4 class="font-italic text-right bg-light text-dark mb-2"><?php echo $_SESSION['mensaje']; ?></h4>
            </p>
        </div>
      </div>
    </div>

    <div class="container mx-auto">
      <form class="" method="post">
        <div class="form-row d-flex justify-content-between ">
          <div class="col-3 mb-3">
            <label>Nombre Proyecto</label>
            <input type="text" class="form-control" name="nombrproy" placeholder="Nombre Proyecto" value="" required>
          </div>
          <div class="col-3 mb-3">
            <label>Fecha de inicio de proyecto</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupPrepend">aaaa-mm-dd</span>
              </div>
              <input type="text" class="form-control" id="fecha_entrega" value="" name="fechaproy" placeholder="Fecha" aria-describedby="inputGroupPrepend" required>
            </div>
          </div>
          <div class="col-5 mb-3">
            <label>Liga a Tracker</label>
            <input type="text" class="form-control" name="ligaproy" placeholder="Liga Proyecto" value="" required>
          </div>
        </div>
        <div class="form-row">
          <label>Responsables</label>
            <div class="col-12 mb-3 btn-group-toggle" data-toggle="buttons">
              <?php
                while ($row_responsables = $result_tablaresponsables->fetch_assoc())
                { ?>
                  <label class="btn btn-info mb-1">
                    <input type="checkbox" name="listaMesa[]" value="<?php echo $row_responsables['MATRICULA']; ?>"> <?php echo $row_responsables['Nombre']; ?>
                  </label>
                <?php } ?>
          </div>
        </div>
        <div class="form-row d-flex justify-content-around">
          <div class="col-12 mb-3">
            <label>Descripción</label>
            <textarea class="form-control" id="descripcion_proyecto" name="descrproy" value="" placeholder="Descripción Proyecto" required></textarea>
          </div>
        </div>
        <div class="form-row d-flex justify-content-around">
          <label>Participantes</label>
            <div class="col-12 mb-3 btn-group-toggle" data-toggle="buttons">
              <?php
                while ($row_participantes = $result_tablaparticipantes->fetch_assoc())
                { ?>
                  <label class="btn btn-info mb-1">
                    <input type="checkbox" name="listaPart[]" value="<?php echo $row_participantes['MATRICULA']; ?>"> <?php echo $row_participantes['Nombre']; ?>
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
            <a class="nav-link text-white" href="contactos_sati.php">Reportar Errores</a>
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
