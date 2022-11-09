<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 1){
  header("Location: login.php");
}
else
{

include_once('header.php');
?>


<main>

    <div class="m-5 bg-light">
      <h1>Solicitudes</h1>
      
      <article class="p-3">
          <div class="table-responsive rounded">
            <table class="table table-striped table-hover rounded">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Id beneficiario</th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Tipo de seguro</th>
                  <th scope="col">Fecha de solicitud</th>
                  <th scope="col">Documento</th>
                  <th scope="col">Aprobado</th>
                  <th scope="col">Opciones</th>
                </tr>
              </thead>
              <tbody id="datosTabla">
                
              </tbody>
            </table>
          </div>
      </article>
    </div>


</main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/solicitudes.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>