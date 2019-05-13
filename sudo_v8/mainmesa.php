<?php
session_start();

require 'mysqli_connect.php';

// Redirrecionamiento
if($_SESSION['Tipo_usuario'] == "u"){header("Location: main.php");}
if(empty($_SESSION['matricula'])){header("Location: index.php");}

// -----------------------------------------STATEMENTS PARA EL ADMINISTRADOR------------------------------------------------
// Obtencion de la matricula
$matricula = $_SESSION['matricula'];

$stmt_nombre = $mysqli->prepare("SELECT USUARIO.Nombre FROM USUARIO WHERE ID_usuario='$matricula';");
$stmt_nombre->execute();
$nombre = $stmt_nombre->get_result();
$row_nombre = $nombre->fetch_assoc();
$_SESSION['Nombre'] = $row_nombre['Nombre'];

$stmt_seleccion_proyectos = $mysqli->prepare("SELECT DISTINCT USUARIO.Nombre, PROYECTOS.Num_proyecto, PROYECTOS.Nom_proy, PROYECTOS.Descripcion, PROYECTOS.Fecha_hora_entrega
  FROM (PROYECTOS INNER JOIN MESA_CREA_PROYECTOS ON (PROYECTOS.Num_proyecto=MESA_CREA_PROYECTOS.Num_proyecto)
    INNER JOIN USUARIO ON (MESA_CREA_PROYECTOS.Id_Mesa_dir=USUARIO.ID_usuario));");

$stmt_seleccion_proyectos->execute();
$proyectos = $stmt_seleccion_proyectos->get_result();

$stmt_seleccion_participantes = $mysqli->prepare("SELECT Nombre, USUARIO_REPORTA_PROYECTO.Completado FROM (USUARIO INNER JOIN USUARIO_REPORTA_PROYECTO
      ON (USUARIO.ID_usuario=USUARIO_REPORTA_PROYECTO.ID_usuario)
    INNER JOIN PROYECTOS
      ON (PROYECTOS.Num_proyecto=USUARIO_REPORTA_PROYECTO.Num_proyecto))
    WHERE (USUARIO_REPORTA_PROYECTO.Num_proyecto = ?);");

//Para desplegar todos los proyectos (mesa directiva)
$heading = "heading";
$collapse = "collapse";
$counter = 0;

//Insercion ID, nombre, rol ESTO SE USA???
$stmt_insercion_usuario = $mysqli->prepare("INSERT INTO USUARIO (ID_usuario, nombre, Rol, contrasena, Tipo_usuario, Desempeno)
VALUES (?,?,?,1234,'?',5);");

// Remocion proyecto
$stmt_remocion_usuario = $mysqli->prepare("DELETE FROM USUARIO WHERE ID_usuario=?");

// Cambiar datos
$stmt_actualizacion = $mysqli->prepare("UPDATE USUARIO SET Rol=?, Tipo_usuario=?, Desempeno=? WHERE ID_usuario=?");
 ?>

 <!doctype html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <link rel="stylesheet" href="assets/css/bootstrap.css">

     <title>Bitácora Mesa Directiva</title>
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
           <li class="nav-item dropdown">
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

     <div class="jumbotron" style="background:url(assets/pics/bg_it.png) no-repeat; background-size: cover;">
       <div class="row">
           <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
             <h1 class="display-4 pb-2">Proyectos Activos</h1>
             <hr class="my-2">
             <p class="font-italic pl-3">Proyectos por cumplir</p>
           </div>
       </div>
     </div>
     <div class="container mx-4">
       <div class="row">
         <div class="accordion", id="accordion">
           <?php
           while ($tupla = $proyectos->fetch_assoc())
           {
            ?>
           <div class="card">
             <div class="card-header" id="<?php echo $heading.$counter; ?>">
               <h5 class="mb-0">
                 <button class="btn btn-link" data-toggle="collapse" data-target="#<?php echo $collapse.$counter; ?>" aria-expanded="true" aria-controls="<?php echo $collapse.$counter; ?>">
                   <?php echo $tupla['Nom_proy']." - ".$tupla['Nombre'] ?>
                 </button>
               </h5>
             </div>
             <div id="<?php echo $collapse.$counter; ?>" class="collapse" aria-labelledby="<?php echo $heading.$counter; ?>" data-parent="#accordion">
               <div class="card-body">
                 <div class="row">
                   <div class="col-7" id="seccion_descripcion">
                     <p><strong>Descripción</strong></p>
                     <p><?php echo $tupla['Descripcion']; ?></p>
                   </div>
                   <div class="col" id="seccion_fecha">
                     <p><strong>Fecha de entrega</strong></p>
                     <p><?php echo $tupla['Fecha_hora_entrega']; ?></p>
                   </div>
                   <div class="col" id="seccion_paticipantes">
                     <p><strong>Participantes</strong></p>
                     <p><?php
                       $stmt_seleccion_participantes->bind_param("i", $tupla['Num_proyecto']);
                       $stmt_seleccion_participantes->execute();
                       $participantes = $stmt_seleccion_participantes->get_result();

                       if ($participantes->num_rows == 1)
                       {
                         $tupla_participantes = $participantes->fetch_assoc();
                         echo $tupla_participantes['Nombre'].".";
                       }
                       elseif ($participantes->num_rows == 0)
                       {
                          echo "NADIE";
                       } else
                       {
                         for ($i=0; $i < $participantes->num_rows; $i++)
                         {
                           $tupla_participantes = $participantes->fetch_assoc();
                           if ($participantes->num_rows == 1) {
                             if ($tupla_participantes['Completado'] == 0) echo $tupla_participantes['Nombre'].". ";
                             else echo $tupla_participantes['Nombre']." (Parte realizada). ";
                           }
                           else
                           {
                             if ($i == ($participantes->num_rows - 1))
                             {
                               if ($tupla_participantes['Completado']==0) echo " y ".$tupla_participantes['Nombre'].".";
                               else echo " y ".$tupla_participantes['Nombre']." (Parte realizada).";

                             }
                             elseif ($i == ($participantes->num_rows - 2)) {
                               if ($tupla_participantes['Completado']==0) echo $tupla_participantes['Nombre']." ";
                               else echo $tupla_participantes['Nombre']." (Parte realizada) ";
                             }else
                             {
                               if ($tupla_participantes['Completado']==0) echo $tupla_participantes['Nombre'].", ";
                               else echo $tupla_participantes['Nombre']." (Parte realizada), ";
                             }
                           }
                         }
                       }?>
                     </p>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <?php
           $counter++;
         } ?>
         </div>
       </div> <!-- row2 -->
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
