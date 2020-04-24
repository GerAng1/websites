<?php
// Para tener variables de sesion
  session_start();

// Importar archivo de conexion
  require '../sec/mysqli_connect.php';

// Redirecciones
  if ($_SESSION['rol'] == 'A') {header("Location: ../main.php");}
  if (empty($_SESSION['rol'])) {header("Location: ../index.php");}

// Variables
  $matricula = $_SESSION['matr'];
  $_SESSION['mensaje'] = '';
  $heading = 'heading';
  $collapse = 'collapse';
  $num = 1;

// Queries
$stmt_tabla_proyectos = $mysqli->prepare(
  "SELECT PROYECTO_ID, Nombre, Descripcion, Fecha_inicio, Completado, Liga
  FROM sudo_tracker.proyecto
  WHERE Completado = '0';");
$stmt_tabla_proyectos->execute();
$result_tabla_proyectos = $stmt_tabla_proyectos->get_result();

$stmt_tabla_responsables = $mysqli->prepare(
  "SELECT usuario.Nombre, responsable_proyecto.PROYECTO_ID
  FROM usuario INNER JOIN responsable_proyecto
  ON usuario.MATRICULA = responsable_proyecto.MATRICULA
  WHERE responsable_proyecto.PROYECTO_ID = ?;");
$stmt_tabla_responsables->bind_param("i", $proyID);
?>
<!-- -- ESTE EL EL MAIN DE LA MESA -- -->
<!doctype html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <link rel="stylesheet" href="../assets/css/bootstrap.css">

     <title>Bitácora Mesa Directiva</title>
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
           <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
               Gestión Proyectos
             </a>
             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="addproyectos.php">Agregar otro proyecto</a>
               <a class="dropdown-item" href="deleteproyectos.php">Eliminar proyecto</a>
               <a class="dropdown-item" href="comentariosmesa.php">Comentar en proyecto</a>
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

     <div class="jumbotron" style="background:url(../assets/pics/bg_it.png) no-repeat; background-size: cover;">
       <div class="row">
           <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
             <h1 class="display-4 pb-2">Proyectos Activos</h1>
             <hr class="my-2">
             <p class="font-italic pl-3">Proyectos por cumplir al <?php echo date("d/m")." a las ".date("H:i")?></p>
           </div>
       </div>
     </div>

     <div class="container mx-4">
       <div class="accordion" id="accordionExample">
         <?php while ($proyecto = $result_tabla_proyectos->fetch_assoc())
         {
           if ($proyecto['Liga'] == 'No hay')
           { $liga = '#No hay'; }
           else { $liga = $proyecto['Liga']; }
           $fecha_para_proyecto = strtotime($proyecto['Fecha_inicio']) - time();?>
           <div class="card">
             <div class="card-header" id="<?php echo $heading.$num; ?>">
               <h2 class="mb-0">
                 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $collapse.$num; ?>" aria-expanded="true" aria-controls="<?php echo $collapse.$num; ?>">
                   <?php echo $proyecto['Nombre'].". (¡".ceil($fecha_para_proyecto / 60 / 60)." horas para evento!)"; ?>
                 </button>
               </h2>
             </div>
             <div id="<?php echo $collapse.$num; ?>" class="collapse" aria-labelledby="<?php echo $heading.$num; ?>" data-parent="#accordionExample">
               <div class="card-body">
                 <div class="row">
                   <div class="col-lg-5" id="colDescripcion">
                     <p class="font-weight-bold">Descripción</p>
                     <p class="font-weight-light">
                       <?php echo $proyecto['Descripcion']; ?>
                     </p>
                   </div>
                   <div class="col-lg-2" id="colFecha">
                     <p class="font-weight-bold">Fecha inicio</p>
                     <p> <?php echo $proyecto['Fecha_inicio']; ?> </p>
                   </div>
                   <div class="col-lg-2" id="colParticipantes">
                     <p class="font-weight-bold">Responsable(s)</p>
                     <p>
                       <?php
                       $proyID = $proyecto['PROYECTO_ID'];
                       $stmt_tabla_responsables->execute();
                       $row_responsables = $stmt_tabla_responsables->get_result();
                       while ($responsable =  $row_responsables->fetch_assoc())
                       {
                         echo $responsable['Nombre']."<br>";
                       }?>
                     </p>
                   </div>
                   <div class="col-lg-3" id="colLiga">
                     <p class="font-weight-bold">Liga a tracker</p>
                     <a href="<?php echo $liga;?>" class="text-decoration-none"><?php echo $proyecto['Liga'];?></a>
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
