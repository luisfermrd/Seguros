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

</main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/principal.js"></script>


<?php
include_once('footer.php');

}
ob_end_flush();
?>