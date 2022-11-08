<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
  header("Location: login.php");
}
else
{

  

include_once('header.php');
?>


<main>

    <div class="m-5 bg-light">
      <h1>Mis seguros</h1>
      
      <article class="p-3">
          <form id="formulario" method="post">
              <input type="hidden" value="<?php echo $_SESSION['id']?>" name="id">
          </form>

          <div class="table-responsive rounded">
            <table class="table table-striped table-hover rounded">
              <thead>
                <tr>
                  <th scope="col">Id beneficiario</th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Tipo de seguro</th>
                  <th scope="col">Fecha inicio - Fecha fin</th>
                  <th scope="col">Valor</th>
                  <th scope="col">Pago</th>
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

    <script src="script/mis_seguros.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>