<!-- -- ESTE EL LA PAGINA DEL BLOG -- -->
<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <title>SATI News</title>
    <link rel="shortcut icon" href="../assets/pics/favicon.ico" type="image/x-icon">

  </head>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5>Misión</h5>
            <p>
              Incluir a todos los alumnos de Ingeniería en Tecnologías
              Computacionales e Ingeniería en Tecnologías de la Información
              como parte de las actividades de la Sociedad de Alumnos,
              así como desarrollar de proyectos que beneficien la vida
              académica y profesional de los mismos, al igual que su
              experiencia como estudiantes del Tecnológico de Monterrey
              Campus Santa Fe.
            </p>
            <img src="../assets/pics/mision.png" width = "100"  height="100" alt="mision">
            <hr>
            <h5>Visión</h5>
            <p>
              Construir y desarrollar una sociedad de alumnos que sea la voz
              que represente de manera efectiva a cada uno de los alumnos de
              Ingeniería en Tecnologías Computacionales e Ingeniería en
              Tecnologías de la Información en el Tecnológico de Monterrey
              Campus Santa Fe, y a la par lograr fomentar las relaciones entre
              alumnos y con otras carreras.
            </p>
             <img src="../assets/pics/vision.jpg" width = "100"  height="100" alt="vision">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light page-scroll">
      <a class="navbar-brand" href="index.php"><img src="../assets/pics/logo_sati.png" height="30" alt="Logo SATI"> SATI News</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Noticias <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a href="#quienes" class="nav-link" data-toggle="modal" data-target="#exampleModalCenter">Misión y Visión</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Eventos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="pasados.php">Pasados</a>
              <a class="dropdown-item" href="futuros.php">Futuros</a>
            </div>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="navbar text-right lead text-body" href="../index.php">¡ Iniciar Sesión !</a>
      </li>
      </ul>
    </nav>
    <!-- End of navbar -->

    <body style="background-color: rgb(0, 0, 0)">
    <!-- Banner -->
    <button class="btn btn-link d-block mx-auto" data-toggle="collapse" data-target="#collapseExample" type="button"
      aria-expanded="false" aria-controls="collapseExample">
      Al usar este sitio acepto a sólo comer cookies.
    </button>
    <div id="collapseExample" class="collapse alert alert-secondary" role="alert">
      <p class="text-center mb-0">¡Broma! Puedes comer cualquier postre de elección.</p>
    </div>
    <!-- End of banner -->

    <div class="container" style="background-color: rgb(0, 0, 0)">
      <div class="row">
        <div class="col">
          <!-- Jumbotron -->
          <div class="jumbotron h-md-50 mx-2"
            style="background-size: cover; background-repeat: no-repeat;background-color: rgb(0, 0, 0)">
            <div class="px-3 h-100 text-white" style="background-color: rgb(0, 0, 0); text-align: center; overflow: auto">
              <h1>¿Quiénes Somos?</h1>
              <img src="../assets/pics/SATI.png" alt="LOGO">
            </div>
          </div>
          <!-- End of Jumbotron -->

          <p class="px-3 h-100 text-white" >
            Alumnos de Ingeniería en Tecnologías Computacionales  (ITC) y  de la Información (ITI) que realizamos
            proyectos para TI relacionados con programación, tecnología y liderazgo

          </p>
        </div>
      </div>
    <div class= "row" style="size: 20px">

      </div>
      <div class= "container">
      <div class="row">
        <div class="col">
          <h1 class="text-center text-white">Algunas Noticias del Mundo de la Tecnología</h1>
        </div>
      </div>
    </div>

      <div class="row justify-content-center">
        <div class="col-10 col-md-4">
          <!-- First Card -->
          <div class="card">
            <img class="card-img-top"
              src="../assets/pics/dirty_keyboard.jpg"
              alt="Card image cap">
            <div class="card-body">
              <p class="card-text">Mantenimineto de tus dispositivos.</p>
            </div>
          </div>
          <!-- End of First Card -->
        </div>

        <div class="col-10 col-md-4">
          <!-- Second Card -->
          <div class="card">
            <img class="card-img-top"
              src="../assets/pics/upgrading_graphics_card.jpg"
              alt="Card image cap">
            <div class="card-body">
              <p class="card-text">Házle un upgrade a tu computadora.</p>
            </div>
          </div>
          <!-- End of Second Card -->
        </div>

        <div class="col-10 col-md-4">
          <!-- Third Card -->
          <div class="card">
            <img class="card-img-top"
              src="../assets/pics/bootstrap.png"
              alt="Card image cap">
            <div class="card-body">
              <p class="card-text">Aprende a hacer una página web.</p>
            </div>
          </div>
          <!-- End of Third Card -->
        </div>
      </div>

      <hr>
      <div class="row">
        <div class="col">
          <h1 class="text-center text-white">Fotos</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-8 col-lg-6 w-50 mx-auto">
          <!-- Carousel -->
          <div id="bootsNstrapExamples" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#bootsNstrapExamples" data-slide-to="0" class="active"></li>
              <li data-target="#bootsNstrapExamples" data-slide-to="1"></li>
              <li data-target="#bootsNstrapExamples" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100"
                  src="../assets/pics/computing1.jpg"
                  alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100"
                  src="../assets/pics/computing2.jpg"
                  alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100"
                  src="../assets/pics/computing3.jpg"
                  alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#bootsNstrapExamples" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#bootsNstrapExamples" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
      <!-- End of Carousel -->





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../assets/js/jQuery.js"></script>
    <script src="../assets/js/Popper.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/scroll.js"></script>
  </body>
</html>
