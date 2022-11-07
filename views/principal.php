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

    <div class="container m-5 bg-light">
      <div class="contenedor">
        <div class="box">
          <img src="../public/img/vida.jpg" alt="Vida">
          <span><a href="form_vida.php">Seguro de vida</a></span>
        </div>
        <div class="box">
          <img src="../public/img/vivienda_2.jpg" alt="Vivienda">
          <span><a href="form_vivienda.php">Seguro de vivienda</a></span>
        </div>
        <div class="box">
          <img src="../public/img/vehiculo.jpg" alt="Vehiculo">
          <span><a href="form_vehiculo.php">Seguro de vehiculo</a></span>
        </div>
      </div>
    </div>

  </main>


<?php
include_once('footer.php');

}
ob_end_flush();
?>