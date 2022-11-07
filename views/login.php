<!doctype html>
<html lang="es">

<head>
  <title>login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="../public/css/index.css">

</head>

<body>
<header>
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">Seguros</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../index.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="login.php">Inicia sesión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="register.php">Registrate</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
<main class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <article class="rounded" style="width: 350px; height: 400px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);">
            <h1 class="p-4 text-center">Inicia sesión</h1>
            <form method="post"  id="formulario">
                <div class="mb-3 ms-4 me-4">
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="helpId"
                        placeholder="Correo electronico" required>
                </div>
                <div class="mb-3 m-4">
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId"
                        placeholder="Contraseña" required>
                </div>

                <div class="d-grid gap-2 ms-4 me-4 mt-4">
                    <button type="submit" name="" id="" class="btn btn-primary">Iniciar</button>
                </div>
            </form>
            <div class="ms-4 me-4 mt-4">
                <a href="register.php" class="d-grid gap-2 text-decoration-none">
                    <button type="button" name="" id="" class="btn btn-dark">Registrarse</button>
                </a>
            </div>
        </article>
    </main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

  <script src="script/login.js"></script>
</body>

</html>