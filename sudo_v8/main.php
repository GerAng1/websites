<?php
session_start();

require 'mysqli_connect.php';

// Redireccionamiento
if($_SESSION['Tipo_usuario'] == "a"){header("Location: mainmesa.php");}
if(empty($_SESSION['matricula'])){header("Location: index.php");}


// --------------------STATEMENTS PARA EL USUARIO NORMAL-----------------------
$_SESSION['messages'] = "";
$matricula = $_SESSION['matricula'];
$completado = $_POST['completado'];

$stmt_nombre = $mysqli->prepare("SELECT USUARIO.Nombre FROM USUARIO WHERE ID_usuario='$matricula';");
$stmt_nombre->execute();
$nombre = $stmt_nombre->get_result();
$row_nombre = $nombre->fetch_assoc();
$_SESSION['Nombre'] = $row_nombre['Nombre'];

// Actualizar la finalizacion de una parte del proyecto
$stmt_completado = $mysqli->prepare("UPDATE USUARIO_REPORTA_PROYECTO SET Completado=1 WHERE ID_usuario='$matricula' AND Num_proyecto=?;");
if (isset($_POST['completado']))
{
  $_SESSION['messages'] = "¡Tu proyecto completado se ha quitado de la lista!";
  $stmt_completado->bind_param("s", $_POST['completado']);
  $stmt_completado->execute();
}


// Obtener los proyectos en donde participa el usuario en linea
$stmt_seleccion_proyectos = $mysqli->prepare("SELECT Proyectos.Num_proyecto, PROYECTOS.Nom_proy, PROYECTOS.Descripcion, PROYECTOS.Fecha_hora_entrega FROM (PROYECTOS
INNER JOIN USUARIO_REPORTA_PROYECTO ON PROYECTOS.Num_proyecto=USUARIO_REPORTA_PROYECTO.Num_proyecto) WHERE ID_usuario='$matricula' AND USUARIO_REPORTA_PROYECTO.Completado=0;");
$stmt_seleccion_proyectos->execute();
$proyectos = $stmt_seleccion_proyectos->get_result();

// Cuales son los otros participantes de los proyectos en cuestion
$stmt_seleccion_participantes = $mysqli->prepare("SELECT Nombre FROM (USUARIO INNER JOIN USUARIO_REPORTA_PROYECTO
      ON (USUARIO.ID_usuario=USUARIO_REPORTA_PROYECTO.ID_usuario)
    INNER JOIN PROYECTOS
      ON (PROYECTOS.Num_proyecto=USUARIO_REPORTA_PROYECTO.Num_proyecto))
    WHERE (USUARIO_REPORTA_PROYECTO.Num_proyecto = ? AND USUARIO.ID_usuario<>'$matricula');");

// Para desplegar los PROYECTOS
$heading = "heading";
$collapse = "collapse";
$counter = 0;
?>
<!-- ESTE EL EL MAIN DEL USUARIO -->
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>SUDO Tracker</title>
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
            <h1 class="pb-2 display-4">Tus Proyectos</h1>
            <p class="pl-3 font-italic" id="grupo_proys">Proyectos pendientes</p>
            <hr class="my-2">
            <h4 class="font-italic text-right mb-2"><?php echo $_SESSION['messages']; ?></h4>
          </div>
        </div>
      </div>
    <div class="container mx-4">
      <div class="row">
        <div class="accordion" id="accordion">
          <?php while ($tupla = $proyectos->fetch_assoc())
          { ?>
            <div class="card">
              <div class="card-header" id="<?php echo $heading.$counter; ?>">
                <h5 class="mb-0">
                  <button class="btn btn-link" data-toggle="collapse" data-target="#<?php echo $collapse.$counter; ?>" aria-expanded="true" aria-controls="<?php echo $collapse.$counter; ?>">
                    <?php echo $tupla['Nom_proy']; ?>
                  </button>
                </h5>
              </div>

              <div id="<?php echo $collapse.$counter; ?>" class="collapse" aria-labelledby="<?php echo $heading.$counter; ?>" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6" id="seccion_descripcion">
                      <p><strong>Descripción</strong></p>
                      <p><?php echo $tupla['Descripcion']; ?></p>
                    </div>
                    <div class="col-auto" id="seccion_fecha">
                      <p><strong>Fecha de entrega</strong></p>
                      <p><?php echo $tupla['Fecha_hora_entrega']; ?></p>
                    </div>
                    <div class="col-auto" id="seccion_paticipantes">
                      <p><strong>Participantes</strong></p>
                      <p>
                        <?php
                        $stmt_seleccion_participantes->bind_param("i", $tupla['Num_proyecto']);
                        $stmt_seleccion_participantes->execute();
                        $participantes = $stmt_seleccion_participantes->get_result();
                          while($tupla_participantes = $participantes->fetch_assoc())
                          {
                            echo $tupla_participantes['Nombre'].", "."<br>";
                          }
                          echo "y tú";
                        ?>
                      </p>
                    </div>
                    <div class="col" id="seccion_completado">
                      <p><strong>Completado</strong> </p>
                      <form  method="post">
                      <input type="checkbox" name="completado" id="completado" value="<?php echo $tupla['Num_proyecto']; ?>">
                      <input type="submit" value="Enviar" class="btn btn-info btn-sm">
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php $counter += 1; } ?>
          </div>
      </div> <!-- row2 -->
    </div> <!-- container1 -->

    <div class="row-fluid">
      <div class="text-center bg-dark mt-5">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link active text-white" href="contactos_sudo.php">Contactos Mesa Directiva</a>
          </li>
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
