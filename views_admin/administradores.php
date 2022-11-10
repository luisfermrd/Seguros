<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 1) {
  header("Location: login.php");
} else {

  include_once('header.php');
?>


  <main>
    <div class="m-5 bg-light">
      <div class="row p-2">
        <div class="col-10">
          <h1>Administradores</h1>
        </div>
        <div class="col-2 justify-content-end">
         <button type="button" class="btn btn-primary" id="nuevoEvento">Nuevo Administrador</button> 
        </div>
      </div>

      <article class="p-3">
        <div class="table-responsive rounded">
          <table class="table table-striped table-hover rounded">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Tipo id</th>
                <th scope="col">Nombres</th>
                <th scope="col">Correo</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody id="datosTabla">

            </tbody>
          </table>
        </div>

        <div class="modal oculto">
          <article class="rounded bg-light" style="width: 450px; height: 550px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);">
            <h1 class="p-3 text-center">Formulario de registro</h1>
            <form method="post" id="formulario">
              <div class="mb-3 ms-4 me-4">
                <label for="nit" class="form-label">Tipo de docuemento(*)</label>
                <select name="tipo_documento" class="form-select" required>
                  <option value="Cedula de ciudadania">Cedula de ciudadania</option>
                  <option value="Cedula de extrangeria">Cedula de extrangeria</option>
                  <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                  <option value="Pasaporte">Pasaporte</option>
                </select>
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

              <div class="container-botones">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger" id="cerrar">Cerrar</button>
              </div>
            </form>
          </article>
        </div>
      </article>
    </div>

  </main>

  <!--jquey -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="script/administradores.js"></script>

<?php
  include_once('footer.php');
}
ob_end_flush();
?>