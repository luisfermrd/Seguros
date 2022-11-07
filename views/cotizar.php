<!doctype html>
<html lang="es">

<head>
  <title>Cotizar</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

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
<main style="min-height: 100vh;">
    <h1 class="p-3 text-center">Para cotizar tu seguro, por favor llena los campos necesarios</h1>
    <section class="d-flex justify-content-center align-items-start gap-5 flex-wrap">
        <article class="rounded" style="width: 450px; height: 580px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);">
            <form  method="post" id="formulario">
                <div class="mb-3 ms-4 me-4 mt-4">
                    <label for="num_personas" class="form-label">Numero de personas, vehiculos o viviendas:</label>
                    <input type="number" class="form-control" name="num_personas"  aria-describedby="helpId" required placeholder="Numero de personas, vehiculos o viviendas" value="1">
                </div>
                <div class="mb-3 ms-4 me-4">
                        <label for="seguro" class="form-label">Que tipo de seguro desea cotizar</label>
                        <select name="seguro" class="form-select" required>
                            <option value="vida">Seguro de vida</option>
                            <option value="vivienda">Seguro de vivienda</option>
                            <option value="vehiculo">Seguro de vehiculo</option>
                        </select>
                    </div>
                    <div class="mb-3 ms-4 me-4">
                        <label for="tipo_seguro" class="form-label">Seleccione un plan</label>
                        <select name="tipo_seguro" class="form-select" required>
                            <option value="basico">Básico</option>
                            <option value="estandar">Estándar</option>
                            <option value="premiun">Premiun</option>
                        </select>
                    </div>
                    <div class="mb-3 ms-4 me-4">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" aria-describedby="helpId" required>
                    </div>
                    <div class="mb-3 ms-4 me-4">
                        <label for="fecha_fin" class="form-label">Fecha de fin:</label>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" aria-describedby="helpId" required>
                    </div>
    
                    <div class="d-grid gap-2 ms-4 me-4 mt-4">
                        <button type="submit" name="" id="" class="btn btn-primary">Cotizar</button>
                    </div>
                </form>
                <div class="ms-4 me-4 mt-4">
                    <a href="../index.html" class="d-grid gap-2 text-decoration-none">
                        <button type="button" name="" id="" class="btn btn-dark">Volver</button>
                    </a>
                </div>
            </article>
            <article class="rounded bg-dark" style="width: 450px; height: 350px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);">
                <h2 class="text-light text-center p-3">Seguros</h2>
                <div class="container ps-5 pe-5 pt-2">
                <p id="num_personas" class="text-light fw-bold">Número de asegurados: 1</p>
                <p class="text-light fw-bold">Días asegurados:</p>
                <p id="dias_agregados" class="text-light"></p>
                <p class="text-light fw-bold">Plan seleccionado:</p>
                <p id="plan_seleccionado" class="text-light"></p>
                <hr class="border border-primary border-3 opacity-75">
                <div class="d-flex justify-content-between">
                    <p class="text-light fw-bold">Total:</p>
                    <p id="total" class="text-light fw-bold">0</p>
                </div>
                </div>
            </article>
        </section>
    </main>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

    <script src="script/cotizar.js"></script>
</body>

</html>