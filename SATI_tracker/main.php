<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require 'sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'M') {header("Location: mesa/mainmesa.php");}
  if (empty($_SESSION['rol'])) {header("Location: index.php");}

// Variables
  $matricula = $_SESSION['matr'];
  $_SESSION['mensaje'] = '';
  $heading = 'heading';
  $collapse = 'collapse';
  $num = 1;

// Queries
$stmt_tabla_proyectos = $mysqli->prepare(
  "SELECT DISTINCT
    proyecto.PROYECTO_ID,
    proyecto.Nombre,
    proyecto.Descripcion,
    proyecto.Fecha_inicio,
    proyecto.Liga,
    usuario_tiene_proyecto.MATRICULA
  FROM
      proyecto INNER JOIN usuario_tiene_proyecto
      ON (proyecto.PROYECTO_ID = usuario_tiene_proyecto.PROYECTO_ID)
  WHERE
      usuario_tiene_proyecto.MATRICULA = '$matricula' AND usuario_tiene_proyecto.Completo_parte = 0;");
$stmt_tabla_proyectos->execute();
$result_tabla_proyectos = $stmt_tabla_proyectos->get_result();

$stmt_tabla_participantes = $mysqli->prepare(
  "SELECT usuario.Nombre, usuario_tiene_proyecto.PROYECTO_ID
  FROM usuario INNER JOIN usuario_tiene_proyecto
  ON usuario.MATRICULA = usuario_tiene_proyecto.MATRICULA
  WHERE usuario_tiene_proyecto.PROYECTO_ID = ?;");
$stmt_tabla_participantes->bind_param("i", $proyID);

$stmt_completado = $mysqli->prepare(
  "UPDATE `sudo_tracker`.`usuario_tiene_proyecto`
  SET `Completo_parte` = '1'
  WHERE (`MATRICULA` = '$matricula') and (`PROYECTO_ID` = ?);");
$stmt_completado->bind_param("i", $completado);

if (isset($_POST['completado']))
{
  $completado = $_POST['completado'];
  $_SESSION['mensaje'] = "¡Tu proyecto completado se ha quitado de la lista!";
  $stmt_completado->execute();
  header("Location: mesa/mainmesa.php");
}


?>

<!-- -- ESTE EL EL MAIN DEL USUARIO ACTIVO -- -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <title>SATI Tracker</title>
    <link rel="shortcut icon" href="assets/pics/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="index.php"><img src="assets/pics/logo_sati.png" height="30" alt="Logo SATI">  SATI Tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
          <li class="nav-item">
            <a class="nav-link" href="comentarios.php">¿Dudas?</a>
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
      <div class="row">
          <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
            <h1 class="display-4 pb-2">Tus Proyectos</h1>
            <p class="font-italic pl-3">Proyectos por cumplir al <?php echo date("d/m")." a las ".date("H:i")?></p>
            <hr class="my-2">
            <h4 class="font-italic text-right bg-light text-dark mb-2"><?php echo $_SESSION['mensaje']; ?></h4>
          </div>
      </div>
    </div>

    <div class="container mx-4">
      <div class="accordion" id="accordionExample">
        <?php while ($row_proyecto = $result_tabla_proyectos->fetch_assoc())
        {
          if ($row_proyecto['Liga'] == 'No hay')
          { $liga = '#No hay'; }
          else { $liga = $row_proyecto['Liga']; }
          $fecha_para_proyecto = strtotime($row_proyecto['Fecha_inicio']) - time();?>
          <div class="card">
            <div class="card-header" id="<?php echo $heading.$num; ?>">
              <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $collapse.$num; ?>" aria-expanded="true" aria-controls="<?php echo $collapse.$num; ?>">
                  <?php echo $row_proyecto['Nombre'].". (¡".ceil($fecha_para_proyecto / 60 / 60)." horas para evento!)"; ?>
                </button>
              </h2>
            </div>
            <div id="<?php echo $collapse.$num; ?>" class="collapse" aria-labelledby="<?php echo $heading.$num; ?>" data-parent="#accordionExample">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4" id="colDescripcion">
                    <p class="font-weight-bold">Descripción</p>
                    <p class="font-weight-light">
                      <?php echo $row_proyecto['Descripcion']; ?>
                    </p>
                  </div>
                  <div class="col-lg-2" id="colFecha">
                    <p class="font-weight-bold">Fecha inicio</p>
                    <p> <?php echo $row_proyecto['Fecha_inicio']; ?> </p>
                  </div>
                  <div class="col-lg-2" id="colParticipantes">
                    <p class="font-weight-bold">Participantes</p>
                    <p>
                      <?php
                      $proyID = $row_proyecto['PROYECTO_ID'];
                      $stmt_tabla_participantes->execute();
                      $result_tabla_participantes = $stmt_tabla_participantes->get_result();
                      while ($row_participantes =  $result_tabla_participantes->fetch_assoc())
                      {
                        echo $row_participantes['Nombre']."<br>";
                      }?>
                    </p>
                  </div>
                  <div class="col-lg-2" id="colCompletado">
                    <p class="font-weight-bold">Completado</p>
                    <form  method="post">
                      <input type="checkbox" name="completado" id="completado" value="<?php echo $row_proyecto['PROYECTO_ID']; ?>">
                      <button type="submit" name="Enviar" class="btn btn-info btn-sm">Enviar</button>
                    </form>
                  </div>
                  <div class="col-lg-2" id="colLiga">
                    <p class="font-weight-bold">Liga a tracker</p>
                    <a href="<?php echo $liga;?>" class="text-decoration-none"><?php echo $row_proyecto['Liga'];?></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        $num += 1;
        }  ?>

      </div>
    </div> <!-- container1 -->

    <div class="row-fluid">
      <div class="text-center bg-dark mt-5">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link active text-white" href="blog/contactos_sati.php">Contactos Mesa Directiva</a>
          </li>
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
