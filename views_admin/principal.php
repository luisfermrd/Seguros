<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 1) {
  header("Location: login.php");
} else {

  include_once('header.php');
?>


  <head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </head>
  <main>
    <section class=" d-flex pt-5 pb-5 flex-wrap justify-content-around">
      <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
        <div class="card-header">Numero de clientes</div>
        <div class="card-body position-relative">
          <div class="icon">
            <i class="bi bi-people-fill"></i>
          </div>
          <span class="numero" id="clientes">0</span>
        </div>
      </div>
      <div class="card text-bg-secondary mb-3" style="max-width: 18rem;">
        <div class="card-header">Numero de usuarios</div>
        <div class="card-body position-relative">
          <div class="icon">
            <i class="bi bi-person-circle"></i>
          </div>
          <span class="numero" id="usuarios">0</span>
        </div>
      </div>
      </div>
      <div class="card text-bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header">Numero de admins</div>
        <div class="card-body position-relative">
          <div class="icon">
            <i class="bi bi-gear-fill"></i>
          </div>
          <span class="numero" id="admins">0</span>
        </div>
      </div>
      </div>
      <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Total recaudado</div>
        <div class="card-body position-relative">
          <div class="icon">
            <i class="bi bi-currency-dollar"></i>
          </div>
          <span class="numero" id="total">0</span>
        </div>
      </div>
      </div>
    </section>

    <div class="m-5 bg-light px-2">
      <h1 class="text-primary text-uppercase text-center mb-3">Planes y precios</h1>
      <article class="p-3">
        <div class="table-responsive rounded">
          <table class="table caption-top">
            <caption>Precios de los planes de seguros</caption>
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Tipo</th>
                <th scope="col">Básico</th>
                <th scope="col">Estándar</th>
                <th scope="col">Premiun</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody id="datosTabla">

            </tbody>
          </table>
        </div>
      </article>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar precios</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" id="formulario">
              <div class="mb-3 ms-4 me-4">
                <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" readonly onmousedown="return false;" >
              </div>
              <div class="mb-3 ms-4 me-4">
                <input type="text" class="form-control" name="tipo" id="tipo" aria-describedby="helpId" readonly onmousedown="return false;">
              </div>
              <div class="mb-3 ms-4 me-4">
                <input type="text" class="form-control" name="basico" id="basico" aria-describedby="helpId" placeholder="Básico" required>
              </div>
              <div class="mb-3 ms-4 me-4">
                <input type="text" class="form-control" name="estandar" id="estandar" aria-describedby="helpId" placeholder="Estándar" required>
              </div>
              <div class="mb-3 ms-4 me-4">
                <input type="text" class="form-control" name="premiun" id="premiun" aria-describedby="helpId" placeholder="Premiun" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" >Modificar</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!--jquey -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="script/principal.js"></script>
  <script src="script/planes.js"></script>


<?php
  include_once('footer.php');
}
ob_end_flush();
?>