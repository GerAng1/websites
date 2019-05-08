<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/sudo_v2/assets/bootstrap.css">

    <title>Login SUDO</title>
    <link rel="shortcut icon" href="/sudo_v2/assets/favicon.ico" type="image/x-icon">

  </head>
  <body style="background-image: url(/sudo_v2/assets/bg_it.png); background-size: cover; background-repeat: no-repeat;">
    <!-- Navbar Component -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="sudo_blog.html"><img src="/sudo_v2/assets/logo_sudo.png" height="30" alt="Logo SUDO">  SUDO Tracker</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="sudo_blog.html">Blog <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End of navbar -->
    <div class="container py-5">
      <div class="row pt-5 text-light">
        <div class="col pt-5">
          <div class="card bg-transparent" style="width: 18rem;">
            <img src="/sudo_v2/assets/logo_sudo.png" class="card-img-top" alt="Logo SUDO">
            <div class="card-body">
              <h2 class="card-text text-light text-center">SUDO Login</h2>
            </div>
          </div>
        </div>
        <div class="col"></div>
        <div class="col pt-5">
          <form class="" action="main.php" method="POST">
            <div class="form-group">
              <label for="correo_e">Correo Institucional</label>
              <input type="email" class="form-control" name="correo_e" id="correo_e" required="" placeholder="matrícula@itesm.mx">
            </div>
            <div class="form-group">
              <label for="pase_entrada">Contraseña</label>
              <input type="password" class="form-control" name="pw" id="pase_entrada" required="" placeholder="Contraseña">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Iniciar Sesión"></input>
          </form>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-light" href="contactos_sudo.html">¿Olvidó Contraseña?</a>
        </div>
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
