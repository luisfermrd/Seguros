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



</main>


<?php
include_once('footer.php');

}
ob_end_flush();
?>