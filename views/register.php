<!doctype html>
<html lang="es">

<head>
  <title>Registrar</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="public/css/index.css">

</head>

<body>
  <header>
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">Seguros</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../index.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="login.php">Iniciar sesión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="register.php">Regístrate</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <article class="rounded" style="width: 450px; height: 550px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);">
      <h1 class="p-3 text-center">Formulario de registro</h1>
      <form method="post" id="formulario">
        <div class="mb-3 ms-4 me-4">
          <div class="form-floating">
            <select name="tipo_documento" class="form-select" aria-label="Floating label select example" required>
              <option value="Cedula de ciudadania">Cedula de Ciudadanía</option>
              <option value="Cedula de extranjeria">Cedula de Extranjería</option>
              <option value="Tarjeta de identidad">Tarjeta de Identidad</option>
              <option value="Pasaporte">Pasaporte</option>
            </select>
            <label for="nit">Tipo de documento(*)</label>
          </div>
        </div>
        <div class="mb-3 ms-4 me-4">
          <input type="number" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="Numero de documento" required>
        </div>
        <div class="mb-3 ms-4 me-4">
          <input type="text" class="form-control" name="names" id="names" aria-describedby="helpId" placeholder="Nombres y apellidos" required>
        </div>
        <div class="mb-3 ms-4 me-4">
          <input type="email" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Correo electronico" required>
        </div>
        <div class="mb-3 ms-4 me-4">
          <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Contraseña" required>
        </div>

        <div class="d-grid gap-2 ms-4 me-4 mt-4">
          <button type="submit" name="" id="" class="btn btn-primary">Registrarse</button>
        </div>
      </form>
      <div class="ms-4 me-4 mt-4">
        <a href="login.php" class="d-grid gap-2 text-decoration-none">
          <button type="button" name="" id="" class="btn btn-dark">Iniciar sesión</button>
        </a>
      </div>
    </article>
  </main>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <!--jquey -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script src="script/registrar.js"></script>
</body>

</html>