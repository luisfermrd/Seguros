<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
  header("Location: login.php");
}
else{

    if(!isset($_GET["id"])){
        header("Location: principal.php");
    }

    $id = $_GET["id"];



include_once('header.php');
?>


<main style="min-height: 100vh;">

    <div class="container p-4 m-2">
        <form id="formulario" method="post">
            <input type="hidden" value="<?php echo $id ?>" name="ref_pago">
        </form>
        <div class="row">
            <div id="datos">
                
            </div>
            
            <div class="form-group d-flex justify-content-between">
                <a href="mis_seguros.php">
                    <button type="button"  class="btn btn-danger row-3 mt-2"> Regresar</button>
                </a>
            </div>
        </div>
    </div>


</main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/detalles.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>