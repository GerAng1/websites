<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/sudo_v2/assets/bootstrap.css">

    <title>Bitácora Mesa Directiva</title>
  </head>
  <body>
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="mainmesa.php"><img src="/sudo_v2/assets/logo_sudo.png" height="30" alt="Logo SUDO">  SUDO Tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="sudo_blog.html">Blog <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cuentamesa.php">Cuenta</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Gestión Proyectos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="proyectosmesa.php">Agregar otro proyecto</a>
              <a class="dropdown-item" href="proyectosmesa.php">Modificar proyecto</a>
              <a class="dropdown-item" href="proyectosmesa.php">Eliminar proyecto</a>
              <a class="dropdown-item" href="proyectosmesa.php">Comentar sobre un proyecto</a>
            </div>
          </li>
        </ul>
      </div>
      <a class="navbar text-right lead">Hola Mesa</a>
    </nav>
    <!-- End of navbar -->

    <div class="jumbotron" style="background:url(/sudo_v2/assets/bg_it.png) no-repeat; background-size: cover;">
      <div class="row">
          <div class="m-5 px-4 pt-2 bg-secondary text-white text-left rounded">
            <h1 class="display-4 pb-2">Proyectos Activos</h1>
            <p class="font-italic pl-3"></p>
            <hr class="my-2">
            <div class="pb-3 pt-2 btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-secondary active btn-info">
                <input type="radio" name="options" id="option1" autocomplete="off" checked>Proyectos Futuros
              </label>
              <label class="btn btn-secondary btn-light">
                <input type="radio" name="options" id="option2" autocomplete="off">Proyectos Pasados
              </label>
            </div>
          </div>
      </div>
    </div>
    <div class="container mx-4">
      <div class="row">
        <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Collapsible Group Item #1
                </button>
              </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Collapsible Group Item #2
                </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Collapsible Group Item #3
                </button>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
        </div>
      </div> <!-- row2 -->
    </div> <!-- container1 -->

    <div class="row-fluid">
      <div class="text-center bg-dark mt-5">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link active text-white" href="contactos_sudo.html">Contactos Mesa Directiva</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Reportar Errores</a>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
      integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
      crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
      integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
      crossorigin="anonymous"></script>
  </body>
</html>
