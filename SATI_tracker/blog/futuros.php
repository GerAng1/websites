<!-- -- Futuros proyectos de SATI BLOG -- -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="shortcut icon" href="../assets/pics/favicon.ico" type="image/x-icon">

    <title>Eventos Próximos</title>
  </head>
  <body>

    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="../index.php"><img src="../assets/pics/logo_sati.png" height="30" alt="Logo SATI">  SATI News</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Blog <span class="sr-only">(current)</span></a>
          </li>
            <li class="nav-item">
                <a class="nav-link" href="contactos_sati.php">Contactos</a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle active" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Eventos
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="pasados.php">Pasados</a>
                    <a class="dropdown-item">Futuros</a>
                  </div>
                </li>
        </ul>
      </div>
      <a class="navbar text-right lead text-body" href="../index.php">¡ Iniciar Sesión!</a>
    </nav>
    <!-- End of navbar -->

 <!-- Modal -->
 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-content p-3">
          <h1>Registrate para el evento</h1>
            <div class="form-group">
              <label for="exampleInputEmail1">Nombre Completo</label>
              <input class="form-control"  placeholder="Nombre">
              <small id="emailHelp" class="form-text text-muted">Te mandaremos más información a tu correo</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" requirerd = "" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Evento</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01">
                  <option selected>Cursos de Programación</option>
                  <option value="1">Torneo de Videojuegos</option>
                  <option value="2">Día ITC</option>
                  <option value="3">Code Challenge</option>
                </select>
            </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Confirmar Asistencia</button>
              </div>
      </div>
    </div>
  </div>

    <div class="jumbotron" style= "background-color: black">
        <h1 class="display-4" style="color: white">Eventos Futuros</h1>
        <p class="lead" style="color: white">Semestre agosto-diciembre 2019</p>
        <img src="../assets/pics/sati2.png" alt="SATI">
      </div>

      <!-- FALTAN FOTOS  -->
    <div class="container-fluid">
      <div class="card-group">
        <div class="card" style="width: 18rem;">
            <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
            <div class="card-body">
              <h5 class="card-title">Cursos de Programación</h5>
              <p class="card-text">Con el objetivo de adquirir conocimientos en áreas de tecnología emergente, realizaremos cursos de capacitación para estudiantes de la carrera. Alguno de los enfoques incluyen: Machine Learning Ciencias de Datos, Internet of Things, Cybersecurity, entre otros. </p>
              <a data-toggle="modal" style = "color: white; border:none" data-target="#exampleModalCenter" class="btn btn-primary">Asisitiré</a>
            </div>
          </div>
          <div class="card" style="width: 18rem;">
              <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
              <div class="card-body">
                <h5 class="card-title">Code Challenge</h5>
                <p class="card-text">Pequeños hackathons de 4-7 horas donde se propone un problema de programación y se premia a aquel capaz de resolverlo.                 </p>
                <a  class="btn btn-primary" style = " border:none; color: white" data-toggle="modal" data-target="#exampleModalCenter">Asistiré</a>
              </div>
            </div>
            <div class="card" style="width: 18rem;">
                <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
                <div class="card-body">
                  <h5 class="card-title">WICS</h5>
                  <p class="card-text">Realizamos eventos (pláticas, conferencias y reuniones) en donde hablamos de las mujeres como minoría en el mundo de la programación. Al igual que realizar proyectos que inspiran a niñas de nivel preparatoria a ingresar al área de STEM (Science Technology Engineering and Mathematics) durante su carrera profesional.</p>
                  <a class="btn btn-primary" style = "border:none; color: white"data-toggle="modal" data-target="#exampleModalCenter">Asistiré</a>
                </div>
              </div>
      </div>
    </div>

    <!-- JavaScript -->
    <script src="../assets/js/jQuery.js"></script>
    <script src="../assets/js/Popper.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>
